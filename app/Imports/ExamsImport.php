<?php
  
namespace App\Imports;
  
use App\Models\ExamQuestion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
  
class ExamsImport implements ToModel, WithHeadingRow
{
	protected $exam_head_id;
	public function __construct(int $exam_head_id) 
    {
        $this->exam_head_id = $exam_head_id;
    }

	/**
	* @param array $row
	*
	* @return \Illuminate\Database\Eloquent\Model|null
	*/
	public function model(array $row)
	{
		return new ExamQuestion([
			'exam_head_id'    	=>  $this->exam_head_id,
			'question_title'    => $row['question'],
			'answer_a'          => $row['answer_a'], 
			'answer_b'          => $row['answer_b'], 
			'answer_c'          => $row['answer_c'], 
			'answer_d'          => $row['answer_d'], 
			'right_answer'      => $row['right_answer'],
		]);
	}
}