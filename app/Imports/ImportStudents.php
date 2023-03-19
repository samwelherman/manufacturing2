<?php

namespace App\Imports;

use App\Models\School\Student;
use App\Models\JournalEntry ;
use App\Models\AccountCodes ;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use DateTime;
use App\Models\Transaction;
use App\Models\Accounts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportStudents  implements ToCollection,WithHeadingRow

{ 
//, WithValidation
   // use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
     
        //  $myDateTime = DateTime::createFromFormat('Y-m-d', strtotime($row[2]));
        //  $year = $myDateTime->format('Y');
        //  $month = $myDateTime->format('M');


         foreach ($rows as $row) 
      {
      
     $student= Student::create([
        'student_name' => $row['student_name'],
          'gender' => $row['gender'],     
        'parent_name' => $row['parent_name'],
        'parent_phone' => $row['parent_phone'],
          'level' => $row['level'],
        'class' => $row['class'],
         'yearStudy' =>  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['registration_date'])->format('Y-m-d'), 
        'added_by' => auth()->user()->added_by,
        ]);
           
    }

  }  
}
