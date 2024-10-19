<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;

class GroupExportController extends Controller
{
    public function exportToWord()
    {
        try {
            $groups = Group::all();
            $templatePath = resource_path('templates/template-group.docx');
            $templateProcessor = new TemplateProcessor($templatePath);

            $replacements = array();
            $count = count($groups);
            foreach ($groups as $index => $group) {

                $imagePath = public_path($group->link_foto_1); // Path to the uploaded image
                $imagePath2 = public_path($group->link_foto_2); // Path to the uploaded image

                $replacements[] = array(
                    'no' => $index + 1,
                    'farmer_group' => $group->farmer_group,
                    'chairman' => $group->chairman,
                    'address' => $group->address,
                    'link_foto_1' => $templateProcessor->setImageValue('link_foto_1', [
                        'path' => $imagePath,
                        'width' => 400,
                        'height' => 200,
                        'ratio' => false
                    ]),
                    'link_foto_2' => $templateProcessor->setImageValue('link_foto_2', [
                        'path' => $imagePath2,
                        'width' => 500,
                        'height' => 300,
                        'ratio' => false
                    ]),
                    'page_break'    => ($index < $count - 1) ? '<w:br w:type="page"/>' : ''
                );
            }

            $templateProcessor->cloneBlock('group_block', count($replacements), true, false, $replacements);

            // Simpan file Word yang sudah diproses
            $fileName = 'Kelompok Tani.docx';
            $filePath = storage_path('app/public/' . $fileName);
            $templateProcessor->saveAs($filePath);

            // Berikan file untuk diunduh
            return response()->download($filePath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
