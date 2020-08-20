<?php

use App\Models\Bank;
use App\Models\Design;
use Illuminate\Database\Seeder;

class DesignSeeder extends Seeder
{
    public function run()
    {
        Eloquent::unguard();

        $this->createDesigns();
    }

    private function createDesigns()
    {
        $designs = [
            ['id' => 1, 'name' => 'Plain', 'user_id' => null, 'company_id' => null, 'is_custom' => false, 'design' => '', 'is_active' => true],
            ['id' => 2, 'name' => 'Clean', 'user_id' => null, 'company_id' => null, 'is_custom' => false, 'design' => '', 'is_active' => true],
            ['id' => 3, 'name' => 'Bold', 'user_id' => null, 'company_id' => null, 'is_custom' => false, 'design' => '', 'is_active' => true],
            ['id' => 4, 'name' => 'Modern', 'user_id' => null, 'company_id' => null, 'is_custom' => false, 'design' => '', 'is_active' => true],
            ['id' => 5, 'name' => 'Business', 'user_id' => null, 'company_id' => null, 'is_custom' => false, 'design' => '', 'is_active' => true],
            ['id' => 6, 'name' => 'Creative', 'user_id' => null, 'company_id' => null, 'is_custom' => false, 'design' => '', 'is_active' => true],
            ['id' => 7, 'name' => 'Elegant', 'user_id' => null, 'company_id' => null, 'is_custom' => false, 'design' => '', 'is_active' => true],
            ['id' => 8, 'name' => 'Hipster', 'user_id' => null, 'company_id' => null, 'is_custom' => false, 'design' => '', 'is_active' => true],
            ['id' => 9, 'name' => 'Playful', 'user_id' => null, 'company_id' => null, 'is_custom' => false, 'design' => '', 'is_active' => true],
        ];

        foreach ($designs as $design) {
            $d = Design::find($design['id']);

            if (!$d) {
                Design::create($design);
            }
        }

        foreach (Design::all() as $design) {
            $class = 'App\Services\PdfMaker\Designs\\'.$design->name;
            $invoice_design = new $class();
            $invoice_design->document();

            $design_object = new \stdClass;
            $design_object->includes = $invoice_design->getSectionHTML('includes');
            $design_object->header = $invoice_design->getSectionHTML('head', false);
            $design_object->body = $invoice_design->getSectionHTML('body', false);
            $design_object->product = $invoice_design->getSectionHTML('product-table');
            $design_object->task = $invoice_design->getSectionHTML('task-table');
            $design_object->footer = $invoice_design->getSectionHTML('footer', false);

            $design->design = $design_object;
            $design->save();
        }
    }
}
