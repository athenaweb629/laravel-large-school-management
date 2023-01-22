<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\AcademicYear\AcademicYearService;

class ListPromotionsTable extends Component
{
    public $academicYear;

    public function mount(AcademicYearService $academicYearService)
    {
        if (!$this->academicYear) {
            $this->academicYear = auth()->user()->school->load('academicYear')->academicYear->first();
        } else {
            $this->academicYear = $academicYearService->getAcademicYearById($this->academicYear);
        }
        // $this->promotions = $studentService->getPromotionsByAcademicYearId($this->academicYear->id)->load('oldClass', 'oldSection', 'newClass', 'newSection');
    }

    public function render()
    {
        return view('livewire.list-promotions-table');
    }
}
