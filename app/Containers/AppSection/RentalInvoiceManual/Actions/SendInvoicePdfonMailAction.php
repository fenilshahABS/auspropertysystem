<?php

namespace App\Containers\AppSection\RentalInvoiceManual\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\RentalInvoiceManual\Models\RentalInvoiceManual;
use App\Containers\AppSection\RentalInvoiceManual\Tasks\SendInvoicePdfonMailTask;
use App\Containers\AppSection\RentalInvoiceManual\UI\API\Requests\CreateRentalInvoiceManualRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class SendInvoicePdfonMailAction extends ParentAction
{
    use HashIdTrait;

    public function run(CreateRentalInvoiceManualRequest $request, $InputData)
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

        return app(SendInvoicePdfonMailTask::class)->run($path, $InputData);
    }
}
