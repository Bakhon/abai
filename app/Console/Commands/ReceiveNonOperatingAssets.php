<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use SimpleXLS;
use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;
use \jamesiarmes\PhpEws\Client;
use \jamesiarmes\PhpEws\Request\FindItemType;
use \jamesiarmes\PhpEws\Request\GetAttachmentType;
use \jamesiarmes\PhpEws\Request\GetItemType;
use \jamesiarmes\PhpEws\Request\UpdateItemType;

use \jamesiarmes\PhpEws\Enumeration\DefaultShapeNamesType;
use \jamesiarmes\PhpEws\Enumeration\DistinguishedFolderIdNameType;
use \jamesiarmes\PhpEws\Enumeration\ResponseClassType;

use \jamesiarmes\PhpEws\Type\ConstantValueType;
use \jamesiarmes\PhpEws\Type\DistinguishedFolderIdType;
use \jamesiarmes\PhpEws\Type\FieldURIOrConstantType;
use \jamesiarmes\PhpEws\Type\ItemResponseShapeType;
use \jamesiarmes\PhpEws\Type\PathToUnindexedFieldType;
use \jamesiarmes\PhpEws\Type\RestrictionType;
use \jamesiarmes\PhpEws\Type\MessageType;
use \jamesiarmes\PhpEws\Type\ItemChangeType;
use \jamesiarmes\PhpEws\Type\SetItemFieldType;
use \jamesiarmes\PhpEws\Type\ItemIdType;
use \jamesiarmes\PhpEws\Type\IsEqualToType;
use \jamesiarmes\PhpEws\Type\RequestAttachmentIdType;

use \jamesiarmes\PhpEws\ArrayType\NonEmptyArrayOfBaseItemIdsType;
use \jamesiarmes\PhpEws\ArrayType\NonEmptyArrayOfRequestAttachmentIdsType;
use \jamesiarmes\PhpEws\ArrayType\NonEmptyArrayOfBaseFolderIdsType;
use \jamesiarmes\PhpEws\ArrayType\NonEmptyArrayOfItemChangeDescriptionsType;

class receiveNonOperatingAssets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'receive-non-operating-email:cron';
    protected $server = "mail.kmg.kz";
    protected $isDataAvailable = true;
    protected $ews;
    protected $messageOptions = array(
          'id' => '',
          'changeKey' => ''
    );
    private $dzoMapping = array (
        'ТШО' => '"Теңізшевройл" ЖШС / ТОО "Тенгизшевройл"',
        'ПКК' => '"Петро Қазақстан Құмкөл Ресорсиз" АҚ / АО "Петро Казахстан Кумколь Ресорсиз"',
        'ТП' => '"Торғай Петролеум" АҚ / АО "Тургай Петролеум"',
        'ПКИ' => '"Петро Казахстан Венчерс Инк."',
        'НКО' => '"Норт Каспиан Оперейтинг Компани Б.В."',
        'АГ' => '"Амангелді Газ" ЖШС/ ТОО "Амангельды Газ"'
    );

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command receive daily emails with non operating assets';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function processInboundEmail()
    {
        $this->assignMessageOptions();
        if (!$this->isDataAvailable) {
            return;
        }
        $this->markAsRead();
        $this->processMessages();
        $this->scrapDocument();
    }

    public function assignMessageOptions()
    {
        $ews = new Client($this->server, env('VISCENTER_EMAIL_ADDRESS', ''), env('VISCENTER_EMAIL_PASSWORD', ''));
        $ews->setCurlOptions(array(CURLOPT_SSL_VERIFYPEER => false));
        $this->ews = $ews;
        $request = $this->getRequestParams();
        $response = $this->ews->FindItem($request);
        $response_messages = $response->ResponseMessages->FindItemResponseMessage;

        foreach ($response_messages as $response_message) {
            if ($response_message->ResponseClass != ResponseClassType::SUCCESS) {
                continue;
            }
            if (count($response_message->RootFolder->Items->Message) === 0) {
                $this->isDataAvailable = false;
                return;
            }
            $items = $response_message->RootFolder->Items->Message;
            $this->messageOptions['id'] = $items[0]->ItemId->Id;
            $this->messageOptions['changeKey'] = $items[0]->ItemId->ChangeKey;
        }
    }

    public function getRequestParams()
    {
        $request = new FindItemType();
        $request->ParentFolderIds = new NonEmptyArrayOfBaseFolderIdsType();
        $request->Restriction = new RestrictionType();
        $request->Restriction->IsEqualTo = new IsEqualToType();
        $request->Restriction->IsEqualTo->FieldURI = new PathToUnindexedFieldType();
        $request->Restriction->IsEqualTo->FieldURI->FieldURI = 'message:IsRead';
        $request->Restriction->IsEqualTo->FieldURIOrConstant = new FieldURIOrConstantType();
        $request->Restriction->IsEqualTo->FieldURIOrConstant->Constant = new ConstantValueType();
        $request->Restriction->IsEqualTo->FieldURIOrConstant->Constant->Value = "false";
        $request->ItemShape = new ItemResponseShapeType();
        $request->ItemShape->BaseShape = DefaultShapeNamesType::ALL_PROPERTIES;
        $folder_id = new DistinguishedFolderIdType();
        $folder_id->Id = DistinguishedFolderIdNameType::INBOX;
        $request->ParentFolderIds->DistinguishedFolderId[] = $folder_id;
        return $request;
    }

    public function markAsRead()
    {
        $request = new UpdateItemType();
        $request->MessageDisposition = 'SaveOnly';
        $request->ConflictResolution = 'AlwaysOverwrite';
        $request->ItemChanges = array();

        $change = new ItemChangeType();
        $change->ItemId = new ItemIdType();
        $change->ItemId->Id = $this->messageOptions['id'];
        $change->ItemId->ChangeKey = $this->messageOptions['changeKey'];
        $change->Updates = new NonEmptyArrayOfItemChangeDescriptionsType();

        $field = new SetItemFieldType();
        $field->FieldURI = new PathToUnindexedFieldType();
        $field->FieldURI->FieldURI = 'message:IsRead';
        $field->Message = new MessageType();
        $field->Message->IsRead = True;

        $change->Updates->SetItemField[] = $field;

        $request->ItemChanges[] = $change;
        $this->ews->UpdateItem($request);
   }

   public function processMessages()
   {
        $this->deleteExistingFile();
        $request = new GetItemType();
        $request->ItemShape = new ItemResponseShapeType();
        $request->ItemShape->BaseShape = DefaultShapeNamesType::ALL_PROPERTIES;
        $request->ItemIds = new NonEmptyArrayOfBaseItemIdsType();

        $item = new ItemIdType();
        $item->Id = $this->messageOptions['id'];
        $request->ItemIds->ItemId[] = $item;

        $response = $this->ews->GetItem($request);

        $response_messages = $response->ResponseMessages->GetItemResponseMessage;
        $this->processAttachments($response_messages);
    }

    public function processAttachments($messages)
    {
        foreach ($messages as $response_message) {
            if ($response_message->ResponseClass != ResponseClassType::SUCCESS) {
                continue;
            }

            $attachments = array();
            foreach ($response_message->Items->Message as $item) {
                if (empty($item->Attachments)) {
                    continue;
                }
                foreach ($item->Attachments->FileAttachment as $attachment) {
                    $attachments[] = $attachment->AttachmentId->Id;
                }
            }

            $request = new GetAttachmentType();
            $request->AttachmentIds = new NonEmptyArrayOfRequestAttachmentIdsType();
            foreach ($attachments as $attachment_id) {
                $id = new RequestAttachmentIdType();
                $id->Id = $attachment_id;
                $request->AttachmentIds->AttachmentId[] = $id;
            }

            $response = $this->ews->GetAttachment($request);

            $attachment_response_messages = $response->ResponseMessages->GetAttachmentResponseMessage;
            foreach ($attachment_response_messages as $attachment_response_message) {
                if ($attachment_response_message->ResponseClass != ResponseClassType::SUCCESS) {
                    continue;
                }

                $attachments = $attachment_response_message->Attachments->FileAttachment;
                $this->saveAttachment($attachments);
            }
        }
    }

    public function saveAttachment($attachments)
    {
        foreach ($attachments as $attachment) {
            file_put_contents(
                'public/test2.xls',
                $attachment->Content
            );
        }
    }

    public function deleteExistingFile()
    {
        if(file_exists('public/test2.xls')) {
            unlink('public/test2.xls');
        }
    }

    public function scrapDocument()
    {
        if ( $xls = SimpleXLS::parseFile('public/test2.xls') ) {
            $this->processExcelDocument($xls);
        }
        $this->deleteExistingFile();
    }

    public function processExcelDocument($sheet)
    {
      foreach( $sheet->rows() as $r => $row) {
          $this->processColumns($row,$sheet,$r);
      }
    }

    public function processCompanies($inputCompanyName,$row)
    {
        foreach($this->dzoMapping as $companyTicker => $companyName) {
            if ($inputCompanyName === $companyName) {
                $data = $this->getCollectedData($row,$companyTicker);
                $this->insertDataToDB($data);
            }
        }
    }

    public function processColumns($row,$sheet,$r)
    {
        foreach($row as $k => $col) {
            $trimmedColumn = trim($col);
            $this->processCompanies($trimmedColumn,$row);
            if ($trimmedColumn === '"Қарашығанақ Петролеум Опер.Б.В." / "Карачаганак Петролеум Опер. Б.В."') {
                $data = $this->getKPOData($row,'КПО',$sheet,$r);
                $this->insertDataToDB($data);
            }
        }
    }

    public function getCollectedData($row, $dzoName)
    {
        $productionFieldName = 'oil_production_fact';
        $deliveryFieldName = 'oil_delivery_fact';
        if ($dzoName === 'АГ') {
            $productionFieldName = 'condensate_production_fact';
            $deliveryFieldName = 'condensate_delivery_fact';
        }
        $columnMapping = array(
            'oilProduction' => 5,
            'oilDelivery' => 12
        );
        return array (
            $productionFieldName => $row[$columnMapping['oilProduction']],
            $deliveryFieldName => $row[$columnMapping['oilDelivery']],
            'dzo_name' => $dzoName,
            'date' => Carbon::yesterday('Asia/Almaty')
        );
    }

    public function getKPOData($row, $dzoName, $sheet, $rowIndex)
    {
        $columnMapping = array(
            'condensateProduction' => 5,
            'condensateDelivery' => 12,
            'KPOoilProduction' => 8,
            'KPOoilDelivery' => 15
        );
        $yesterdayFact = $this->getYesterdayFact($dzoName);
        return array (
            'oil_production_fact' => $this->getUpdatedFactForRecord($dzoName,$row[$columnMapping['KPOoilProduction']],$yesterdayFact,'oilProduction'),
            'oil_delivery_fact' => $this->getUpdatedFactForRecord($dzoName,$row[$columnMapping['KPOoilDelivery']],$yesterdayFact,'oilDelivery'),
            'condensate_production_fact' => $sheet->rows()[$rowIndex + 2][$columnMapping['condensateProduction']],
            'condensate_delivery_fact' => $sheet->rows()[$rowIndex + 2][$columnMapping['condensateDelivery']],
            'dzo_name' => $dzoName,
            'date' => Carbon::yesterday('Asia/Almaty'),
            'oil_production_fact_absolute' => $row[$columnMapping['KPOoilProduction']],
            'oil_delivery_fact_absolute' => $row[$columnMapping['KPOoilDelivery']]
        );
    }

    public function getYesterdayFact($dzoName)
    {
        $data = array (
            'oilProduction' => 0,
            'oilDelivery' => 0
        );
        $dzoYesterdayData = DzoImportData::query()
            ->whereDate('date',Carbon::now()->subDays(2))
            ->where('dzo_name',$dzoName)
            ->first();
        if (!is_null($dzoYesterdayData)) {
            $data['oilProduction'] = $dzoYesterdayData->oil_production_fact_absolute;
            $data['oilDelivery'] = $dzoYesterdayData->oil_delivery_fact_absolute;
        }
        return $data;
    }

    public function getUpdatedFactForRecord($dzoName,$currentFact,$yesterdayFact,$fieldName) {
        return ((float) $currentFact - $yesterdayFact[$fieldName]) * 0.9;
    }

    public function insertDataToDB ($data)
    {
        DzoImportData::create($data);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->processInboundEmail();
    }
}
