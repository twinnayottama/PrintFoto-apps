<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;

class GroupExportController extends Controller
{
    public function exportToWord(){
        try{
            $groups = Group::all();
            $templatePath = resource_path('templates/template-group.docx');
            $templateProcessor = new TemplateProcessor($templatePath);

             // Loop melalui data group
             foreach ($groups as $index => $group) {
                // Nomor urut dimulai dari 1
                $number = $index + 1;

                // Jika ini adalah data pertama, gunakan setValue
                if ($index === 0) {
                    $templateProcessor->setValue('no#0', $number);
                    $templateProcessor->setValue('farmer_group#0', $group->farmer_group ?? '');
                    $templateProcessor->setValue('chairman#0', $group->chairman ?? '');
                    $templateProcessor->setValue('address#0', $group->address ?? '');
                    $templateProcessor->setValue('link_foto_1#0', $group->link_foto_1 ?? '');
                    $templateProcessor->setValue('link_foto_2#0', $group->link_foto_2 ?? '');
                } else {
                    // Klon blok untuk setiap data group
                    $templateProcessor->cloneBlock('group_block', 0, true, true, [
                        'no#0' => $number,
                        'farmer_group#0' => $group->farmer_group ?? '',
                        'chairman#0' => $group->chairman ?? '',
                        'address#0' => $group->address ?? '',
                        'link_foto_1#0' => $group->link_foto_1 ?? '',
                        'link_foto_2#0' => $group->link_foto_2 ?? ''
                    ]);
                }

                // Tambahkan page break kecuali pada data terakhir
                if ($index < count($groups) - 1) {
                    // Gantikan placeholder page break
                    $templateProcessor->setValue('page_break#' . $index, '<w:br w:type="page"/>');
                }
            }

            // Simpan file Word yang sudah diproses
            $fileName = 'group-data-export.docx';
            $filePath = storage_path('app/public/' . $fileName);
            $templateProcessor->saveAs($filePath);

            // Berikan file untuk diunduh
            return response()->download($filePath)->deleteFileAfterSend(true);
        }catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
