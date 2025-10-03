<?php

namespace App\Containers\AppSection\RentalInvoiceManualProperty\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\RentalInvoiceManualProperty\Models\RentalInvoiceManualProperty;
use App\Containers\AppSection\RentalInvoiceManualProperty\Tasks\SendInvoicePdfonMailPropertyTask;
use App\Containers\AppSection\RentalInvoiceManualProperty\UI\API\Requests\CreateRentalInvoiceManualPropertyRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class SendInvoicePdfonMailPropertyAction extends ParentAction
{
    use HashIdTrait;

    public function run(CreateRentalInvoiceManualPropertyRequest $request, $InputData)
    {

        if (!file_exists(public_path('invoice_pdf/'))) {
            mkdir(public_path('invoice_pdf/'), 0755, true);
        }
        $folderPath = 'public/invoice_pdf/';
        $pdf_base64 = base64_decode($InputData->getInvoicePdf());

        $file_type = "pdf";
        $file = uniqid() . '.' . $file_type;
        $path = public_path('invoice_pdf/' . $file);
        file_put_contents($path, $pdf_base64);

        return app(SendInvoicePdfonMailPropertyTask::class)->run($path, $InputData);
    }
}
