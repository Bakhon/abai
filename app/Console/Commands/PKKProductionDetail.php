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

class PKKProductionDetail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pkk-details-email:cron';
    protected $server = "mail.kmg.kz";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Receive pkk production details by email scraping';

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
