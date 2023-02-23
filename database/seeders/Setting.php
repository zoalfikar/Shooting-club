<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Setting extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared('
        DROP TRIGGER IF EXISTS none_update_able;
        DROP TRIGGER IF EXISTS none_delete_able;
        CREATE TRIGGER none_update_able 
        BEFORE UPDATE ON settings FOR EACH ROW
        BEGIN
        IF UPPER(OLD.name) = "FACILITY" THEN
        SET NEW.name = "facility";
        END IF;
        END;
        CREATE TRIGGER none_delete_able 
        AFTER DELETE ON settings FOR EACH ROW
        BEGIN
        IF UPPER(OLD.name) = "FACILITY" THEN
        INSERT INTO settings (name , value) VALUES ("facility","اسم المنشأة");
        END IF;
        END;
        ');
        DB::table('settings')->insert([
            'name' => "facility",
            'value' => "اسم المنشأة",
        ]);
    }
}
