<?php

namespace App\Http\Controllers\VisCenter\ExcelForm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisCenter\ExcelForm\DzoImportData;
use App\Models\VisCenter\ExcelForm\DzoImportDowntimeReason;
use App\Models\VisCenter\ExcelForm\DzoImportDecreaseReason;
use App\Models\VisCenter\ExcelForm\DzoImportField;
use App\Models\VisCenter\ExcelForm\DzoPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use \jamesiarmes\PhpEws\Client;
use \jamesiarmes\PhpEws\Request\CreateItemType;
use \jamesiarmes\PhpEws\ArrayType\ArrayOfRecipientsType;
use \jamesiarmes\PhpEws\ArrayType\NonEmptyArrayOfAllItemsType;
use \jamesiarmes\PhpEws\Enumeration\BodyTypeType;
use \jamesiarmes\PhpEws\Enumeration\MessageDispositionType;
use \jamesiarmes\PhpEws\Enumeration\ResponseClassType;
use \jamesiarmes\PhpEws\Type\BodyType;
use \jamesiarmes\PhpEws\Type\EmailAddressType;
use \jamesiarmes\PhpEws\Type\MessageType;
use \jamesiarmes\PhpEws\Type\SingleRecipientType;
use \jamesiarmes\PhpEws\Request\SendItemType;
use \jamesiarmes\PhpEws\Enumeration\DistinguishedFolderIdNameType;
use \jamesiarmes\PhpEws\ArrayType\NonEmptyArrayOfBaseItemIdsType;
use \jamesiarmes\PhpEws\Type\DistinguishedFolderIdType;
use \jamesiarmes\PhpEws\Type\ItemIdType;
use \jamesiarmes\PhpEws\Type\TargetFolderIdType;

class ExcelFormController extends Controller
{
    private $host = 'mail.kmg.kz';
    private $emailSubject = 'Заявка на изменение суточных данных в ИС ABAI';
    private $kmgEmails = array (
        'firstMaster' => 's.sugal@kmg.kz',
        'secondMaster' => 's.sugal@kmg.kz',
        'mainMaster' => 's.sugal@kmg.kz',
    );
    private $dzoEmails = array (
        'ЭМГ' => 's.sugal@kmg.kz',
        'УО' => 's.sugal@kmg.kz',
        'КБМ' => 's.sugal@kmg.kz',
        'КОА' => 's.sugal@kmg.kz',
        'ОМГ' => 's.sugal@kmg.kz',
        'КТМ' => 's.sugal@kmg.kz',
        'ММГ' => 's.sugal@kmg.kz',
    );
    private $systemFields = ['id','dzo_import_data_id'];
    private $fieldsOilLosses = [
        'daily_reason_1_losses',
        'daily_reason_2_losses',
        'daily_reason_3_losses',
        'daily_reason_4_losses',
        'daily_reason_5_losses'
    ];

    public function getDzoCurrentData(Request $request)
    {
         $date = Carbon::parse($request->date);

        if ($request->boolean('isCorrected')) {
            $date = Carbon::parse($request->date)->addDays(1);
        }

        $dzoName = $request->request->get('dzoName');
        $dzoImportData = DzoImportData::query()
            ->whereDate('date',$date)
            ->where('dzo_name',$dzoName)
            ->whereNull('is_corrected')
            ->with('importField')
            ->with('importDowntimeReason')
            ->with('importDecreaseReason')
            ->first();

         if (is_null($dzoImportData)) {
            return response()->json($dzoImportData);
         }
         $dzoImportData->fields = $this->getFormattedFields($dzoImportData);

         return response()->json($dzoImportData);
    }

    public function getFormattedFields($dzoImportData)
    {
        return $dzoImportData->importField->mapWithKeys(function ($field) {
           return [$field['field_name'] => $field];
        });
    }

    public function store(Request $request)
    {
        $this->deleteAlreadyExistRecord($request);

        $this->saveDzoSummaryData($request);
        $dzo_summary_last_record = DzoImportData::latest('id')->whereNull('is_corrected')->first();

        $this->saveDzoFieldsSummaryData($dzo_summary_last_record,$request);

        $dzo_downtime_reason = new DzoImportDowntimeReason;
        $downtime_data = $request->request->get('downtimeReason');
        $dzo_downtime_reason = $this->getDzoChildSummaryData($dzo_downtime_reason,$downtime_data,$dzo_summary_last_record);
        $dzo_downtime_reason->save();

        $dzo_decrease_reason = new DzoImportDecreaseReason;
        $decrease_data = $request->request->get('decreaseReason');
        $dzo_decrease_reason = $this->getDzoChildSummaryData($dzo_decrease_reason,$decrease_data,$dzo_summary_last_record);
        $dzo_decrease_reason->save();
    }

    public function deleteAlreadyExistRecord($request)
    {
        $dzoName = $request->request->get('dzo_name');
        $recordDate = $request->request->get('date');
        $todayDzoImportDataRecord = DzoImportData::whereDate('date', Carbon::parse($recordDate))->where('dzo_name', $dzoName)->whereNull('is_corrected')->first();
        if ($this->isAlreadyUploaded($todayDzoImportDataRecord)) {
            DzoImportField::where('dzo_import_data_id',$todayDzoImportDataRecord->id)->delete();
            DzoImportDecreaseReason::where('dzo_import_data_id',$todayDzoImportDataRecord->id)->delete();
            DzoImportDowntimeReason::where('dzo_import_data_id',$todayDzoImportDataRecord->id)->delete();
            DzoImportData::where('id',$todayDzoImportDataRecord->id)->delete();
        }
    }

    public function isAlreadyUploaded($todayDzoImportDataRecord)
    {
        return !is_null($todayDzoImportDataRecord);
    }

    public function saveDzoSummaryData($request)
    {
        $dzo_data = $request->request->all();
        $dzo_summary_data = $this->getDzoSummaryData($dzo_data);
        $dzo_summary_data->save();
    }

    public function getDzoSummaryData($dzo_input_data)
    {
        $children_keys = array(
            'downtimeReason' => 1,
            'decreaseReason' => 2,
            'fields' => 3,
            'import_field' => 4,
            'import_downtime_reason' => 5,
            'import_decrease_reason' => 6
        );
        $dzo_summary_data = new DzoImportData;
        foreach ($dzo_input_data as $key => $item) {
            if (array_key_exists($key, $children_keys)) {
                continue;
            }
            $dzo_summary_data->$key = $dzo_input_data[$key];
        }
        return $dzo_summary_data;
    }

    public function saveDzoFieldsSummaryData($dzo_summary_last_record,$request)
    {
        $fields_data = $request->request->get('fields');
        if (!$fields_data) {
            $fields_data = $request->request->get('import_field');
        }
        if (is_null($fields_data)) {
            return;
        }
        foreach ($fields_data as $field_name => $field) {
            $dzo_import_field_data = $this->getDzoFieldData($field_name,$dzo_summary_last_record,$field);
            $dzo_import_field_data->save();
        }
    }

    public function getDzoFieldData($field_name,$dzo_summary_last_record,$field)
    {
        $dzo_import_field = new DzoImportField;
        $dzo_import_field->importData()->associate($dzo_summary_last_record);
        $dzo_import_field->field_name = $field_name;
        foreach($this->systemFields as $fieldName) {
            unset($field->$fieldName);
        }
        foreach($field as $key => $item) {
            if (in_array($key, $this->systemFields)) {
                continue;
            }
            $dzo_import_field->$key = $field[$key];
        }
        return $dzo_import_field;
    }
    public function getDzoChildSummaryData($child_item,$dzo_input_data,$dzo_summary_last_record)
    {
        $child_item->importData()->associate($dzo_summary_last_record);
        foreach($this->systemFields as $fieldName) {
            unset($dzo_input_data[$fieldName]);
        }

        foreach ($dzo_input_data as $key => $item) {
            $child_item->$key = $dzo_input_data[$key];
        }
        return $child_item;
    }

    public function storeCorrected(Request $request)
    {
        $emails = $request->toList;
        $request->request->remove('toList');
        $isApproveRequired = $this->isProductionRecordExist($request->get('dzo_name'),$request->get('date'));
        $isCorrected = true;
        if (!$isApproveRequired) {
            $isCorrected = null;
            $request->request->set('is_corrected', null);
        }
        $this->saveDzoSummaryData($request);
        $dzo_summary_last_record = DzoImportData::latest('id')->where('is_corrected', $isCorrected)->first();
        $correctedDate = $dzo_summary_last_record->created_at->addHour();
        $dzo_summary_last_record->created_at = $correctedDate;
        $dzo_summary_last_record->save();
        $this->saveDzoFieldsSummaryData($dzo_summary_last_record,$request);

        $dzo_downtime_reason = new DzoImportDowntimeReason;
        $downtime_data = $request->request->get('downtimeReason');
        if (!$downtime_data) {
            $downtime_data = $request->request->get('import_downtime_reason');
        }
        $dzo_downtime_reason = $this->getDzoChildSummaryData($dzo_downtime_reason,$downtime_data,$dzo_summary_last_record);
        $dzo_downtime_reason->save();

        $dzo_decrease_reason = new DzoImportDecreaseReason;
        $decrease_data = $request->request->get('decreaseReason');
        if (!$decrease_data) {
            $decrease_data = $request->request->get('import_decrease_reason');
        }
        $dzo_decrease_reason = $this->getDzoChildSummaryData($dzo_decrease_reason,$decrease_data,$dzo_summary_last_record);
        $dzo_decrease_reason->save();
        if ($isApproveRequired) {
            $client = $this->getEmailClient();
            foreach($emails as $item) {
                $this->sendEmailToMaster($request->request, $client, $item);
            }
        }
    }

    private function isProductionRecordExist($dzoName,$date)
    {
        $existRecord = DzoImportData::query()
            ->whereNull('is_corrected')
            ->where('dzo_name', $dzoName)
            ->whereDate('date', Carbon::parse($date))
            ->first();
        return !is_null($existRecord);
    }

    public function getDailyProductionForApprove()
    {
        $forApprove = DzoImportData::query()
            ->where('is_corrected', true)
            ->where(function($q) {
                return $q
                         ->whereNull('is_approved_by_first_master')
                         ->orWhere('is_approved_by_first_master', true);
             })
             ->where(function($q) {
                return $q
                      ->whereNull('is_approved_by_second_master')
                      ->orWhere('is_approved_by_second_master', true);
            })
            ->with('importField')
            ->with('importDowntimeReason')
            ->with('importDecreaseReason')
            ->get()
            ->toArray();
        $forApproveDates = array_column($forApprove, 'date');
        $forApproveDzo = array_unique(array_column($forApprove, 'dzo_name'));
        $actual = DzoImportData::query()
             ->whereNull('is_corrected')
             ->where(function($q) use($forApproveDates) {
                 foreach ($forApproveDates as $date) {
                    $q->whereDate('date', '=', Carbon::parse($date), 'or');
                 }
             })
             ->whereIn('dzo_name',$forApproveDzo)
             ->with('importField')
             ->with('importDowntimeReason')
             ->with('importDecreaseReason')
             ->get()
             ->toArray();
        $comparedData = array (
            'forApprove' => $forApprove,
            'actual' => $actual
        );
        return $comparedData;
    }

    public function approveDailyCorrection(Request $request)
    {
        $this->deleteDuplicates($request->dzo_name,$request->date,$request->actualId);
        $client = $this->getEmailClient();
        $updateOptions = array(
            $request->currentApproverField => true
        );
        $this->sendApproveEmailToDzo($request->request,$client);
        DzoImportField::where('dzo_import_data_id',$request->actualId)->delete();
        DzoImportDecreaseReason::where('dzo_import_data_id',$request->actualId)->delete();
        DzoImportDowntimeReason::where('dzo_import_data_id',$request->actualId)->delete();
        DzoImportData::where('id',$request->actualId)->delete();
        $updateOptions['is_corrected'] = null;
        $updateOptions['user_id'] = $request->userId;

        DzoImportData::query()
            ->where('id', $request->currentId)
            ->update($updateOptions);
    }

    protected function deleteDuplicates($dzo,$date,$currentId)
    {
        $records = DzoImportData::query()
            ->where('dzo_name',$dzo)
            ->whereDate('date',Carbon::parse($date))
            ->whereNull('is_corrected')
            ->get();
        foreach($records as $record) {
            if ($record->id === $currentId) {
                continue;
            }
            DzoImportField::where('dzo_import_data_id',$record->id)->delete();
            DzoImportDecreaseReason::where('dzo_import_data_id',$record->id)->delete();
            DzoImportDowntimeReason::where('dzo_import_data_id',$record->id)->delete();
            DzoImportData::where('id',$record->id)->delete();
        }
    }

    protected function getEmailClient()
    {
        $username = env('VISCENTER_EMAIL_ADDRESS', '');
        $password = env('VISCENTER_EMAIL_PASSWORD', '');
        $client = new Client($this->host, $username, $password);
        $client->setCurlOptions(array(CURLOPT_SSL_VERIFYPEER => false));
        return $client;
    }

    public function declineDailyCorrection(Request $request)
    {
        $client = $this->getEmailClient();
        $emailBody = "<b>Добрый день!</b> <p>Ваша заявка на изменение суточных данных в ИС ABAI. была <b>отклонена</b><br /><br />
            <b>Детали заявки:</b><br />
            <b>Дата:</b> {$request->date}<br />
            <b>Исполнитель:</b> {$request->user_name}<br />
            <b>Причина:</b> {$request->change_reason}</p>";
        $messageOptions = $this->getEmailOptions($client,$emailBody,$this->dzoEmails[$request->dzo_name]);
        $this->sendEmail($messageOptions,$client);
        DzoImportData::query()
            ->where('id', $request->currentId)
            ->update(
                [
                    'is_corrected' => false,
                    'is_approved' => false,
                    'user_id' => $request->userId
                ]
            );
    }

    protected function getEmailOptions($client, $body, $to)
    {
        $messageOptions = array (
            'id' => null,
            'changeKey' => null
        );
        $request = new CreateItemType();
        $request->Items = new NonEmptyArrayOfAllItemsType();
        $request->MessageDisposition = MessageDispositionType::SAVE_ONLY;
        $message = new MessageType();
        $message->Subject = $this->emailSubject;
        $message->ToRecipients = new ArrayOfRecipientsType();
        $message->From = new SingleRecipientType();
        $message->From->Mailbox = new EmailAddressType();
        $message->From->Mailbox->EmailAddress = env('VISCENTER_EMAIL_ADDRESS', '');
        $recipient = new EmailAddressType();
        $recipient->EmailAddress = $to;
        $message->ToRecipients->Mailbox[] = $recipient;
        $message->Body = new BodyType();
        $message->Body->BodyType = BodyTypeType::HTML;
        $message->Body->_ = $body;
        $request->Items->Message[] = $message;
        $response = $client->CreateItem($request);
        $response_messages = $response->ResponseMessages->CreateItemResponseMessage;

        foreach ($response_messages as $response_message) {
            if ($response_message->ResponseClass != ResponseClassType::SUCCESS) {
                continue;
            }
            foreach ($response_message->Items->Message as $item) {
                $messageOptions['id'] = $item->ItemId->Id;
                $messageOptions['changeKey'] = $item->ItemId->ChangeKey;
            }
        }
        return $messageOptions;
    }

    protected function sendEmail($messageOptions,$client)
    {
        $request = new SendItemType();
        $request->SaveItemToFolder = true;
        $request->ItemIds = new NonEmptyArrayOfBaseItemIdsType();

        $item = new ItemIdType();
        $item->Id = $messageOptions['id'];
        $item->ChangeKey = $messageOptions['changeKey'];
        $request->ItemIds->ItemId[] = $item;

        $send_folder = new TargetFolderIdType();
        $send_folder->DistinguishedFolderId = new DistinguishedFolderIdType();
        $send_folder->DistinguishedFolderId->Id = DistinguishedFolderIdNameType::SENT;
        $request->SavedItemFolderId = $send_folder;
        $response = $client->SendItem($request);

        $response_messages = $response->ResponseMessages->SendItemResponseMessage;
        foreach ($response_messages as $response_message) {
            if ($response_message->ResponseClass != ResponseClassType::SUCCESS) {
                continue;
            }
        }
    }

    protected function sendEmailToMaster($input, $client, $master)
    {
        $emailBody = "<b>Добрый день!</b> <p>Уведомляем вас о необходимости согласовать/отклонить заявку на изменение суточных данных в ИС ABAI.<br /><br />
            <b>Детали заявки:</b><br />
            <b>Дата:</b> {$input->get('date')}<br />
            <b>ДЗО:</b> {$input->get('dzo_name')}<br />
            <b>Исполнитель:</b> {$input->get('user_name')}<br />
            <b>Причина:</b> {$input->get('change_reason')}<br />
            <a href='http://abai.kmg.kz/ru/daily-approve'>Ссылка на Таблицу Согласований</a></p>";
        $messageOptions = $this->getEmailOptions($client,$emailBody,$this->kmgEmails[$master]);
        $this->sendEmail($messageOptions,$client);
    }

    protected function sendApproveEmailToDzo($input, $client)
    {
        $emailBody = "<b>Добрый день!</b> <p>Ваша заявка на изменение суточных данных в ИС ABAI. была <b>одобрена</b><br /><br />
            <b>Детали заявки:</b><br />
            <b>Дата:</b> {$input->get('date')}<br />
            <b>Исполнитель:</b> {$input->get('user_name')}<br />
            <b>Причина:</b> {$input->get('change_reason')}";
        $messageOptions = $this->getEmailOptions($client,$emailBody,$this->dzoEmails[$input->get('dzo_name')]);
        $this->sendEmail($messageOptions,$client);
    }

    public function getFactByMonth(Request $request)
    {
     return DzoImportData::query()
         ->select()
         ->whereNull('is_corrected')
         ->whereYear('date',$request->year)
         ->whereMonth('date',$request->month)
         ->where('dzo_name',$request->dzo)
         ->with('importField')
         ->with('importDowntimeReason')
         ->with('importDecreaseReason')
         ->get();
    }

    public function storeFactByMonth(Request $request)
    {
        $systemFields = ['dzo_name','date'];
        $forUpdate = array();
        $params = $request->request->all();
         foreach(reset($params) as $fact) {
            foreach($fact as $field => $value) {
                if (!in_array($field, $systemFields)) {
                    $forUpdate[$field] = $value;
                }
            }
            DzoImportData::query()
                ->where('dzo_name',$fact['dzo_name'])
                ->whereDate('date',Carbon::parse($fact['date']))
                ->first()
                ->update($forUpdate);
         }
    }

    public function getPlanForReasons(Request $request)
    {
        if ($request->type === 'daily') {
            return $this->getDailyPlan($request->dzo,Carbon::parse($request->date));
        } elseif ($request->type === 'monthly') {
            return $this->getMonthlyPlan($request->dzo,Carbon::parse($request->date));
        } elseif ($request->type === 'yearly') {
            return $this->getYearlyPlan($request->dzo,Carbon::parse($request->date));
        }
    }

    public function getDailyPlan($dzo,$date)
    {
        return DzoPlan::query()
            ->select(['plan_oil','plan_kondensat'])
            ->whereMonth('date',$date)
            ->whereYear('date',$date)
            ->where('dzo',$dzo)
            ->first();
    }

    public function getMonthlyPlan($dzo,$date)
    {
        $dailyPlan = $this->getDailyPlan($dzo,$date);
        return $dailyPlan->plan_oil * $date->day;
    }

    private function getYearlyPlan($dzo,$date)
    {
        $plans = DzoPlan::query()
            ->select(['plan_oil','plan_kondensat','date'])
            ->whereMonth('date','<',$date)
            ->whereYear('date',$date)
            ->where('dzo',$dzo)
            ->get()
            ->toArray();

        $summ = 0;
        foreach($plans as $plan) {
            $daysCount = Carbon::parse($plan['date'])->daysInMonth;
            $summ += $plan['plan_oil'] * $daysCount;
        }

        return $summ;
    }

    public function getFactForReason(Request $request)
    {
        if ($request->type === 'monthly') {
            return [$this->getMonthlyFact($request->dzo,Carbon::parse($request->date),array('oil_production_fact','condensate_production_fact'),'='),
                $this->getOilLosses($request->dzo,Carbon::parse($request->date),$this->fieldsOilLosses,'=')];
        } elseif ($request->type === 'yearly') {
            return [$this->getMonthlyFact($request->dzo,Carbon::parse($request->date),array('oil_production_fact','condensate_production_fact'),'<'),
                $this->getOilLosses($request->dzo,Carbon::parse($request->date),$this->fieldsOilLosses,'<')];
        }
    }

    private function getMonthlyFact($dzo,$date,$fields,$type)
    {
        return DzoImportData::query()
            ->select($fields)
            ->whereMonth('date',$type,$date)
            ->whereYear('date',$date)
            ->where('dzo_name',$dzo)
            ->sum($fields[0]);
    }

    private function getOilLosses($dzo,$date,$fields,$type)
    {
        $ids = DzoImportData::query()
           ->select('id')
           ->whereMonth('date',$type,$date)
           ->whereYear('date',$date)
           ->where('dzo_name',$dzo)
           ->pluck('id')
           ->toArray();
        $oilLosses = DzoImportDecreaseReason::query()
            ->select($fields)
            ->whereIn('dzo_import_data_id',$ids)
            ->get();

        $summ = 0;
        foreach($this->fieldsOilLosses as $fieldName) {
            $summ += $oilLosses->sum($fieldName);
        }

        return $summ;
    }
}
