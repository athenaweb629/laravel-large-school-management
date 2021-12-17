<?php

namespace App\Services\MyClass;

use App\Models\MyClass;
use App\Models\ClassGroup;
use App\Services\School\SchoolService;

class MyClassService{
      //create public properties
      public $school;


      //construct method
    public function __construct(SchoolService $school)
    {
        $this->school = $school;
    }

    public function getAllClasses()
    {
        return collect($this->school->getSchoolById(auth()->user()->school_id)->myClasses->load('classGroup','sections')->all());
    }

    public function getAllClassGroups()
    {
        return ClassGroup::where('school_id', auth()->user()->school_id )->get();
    }

    public function getClassById($id)
    {
        return MyClass::find($id);
    }
    
    public function getClassByIdOrFail($id)
    {
        return $this->school->getSchoolById(auth()->user()->school_id)->myClasses()->findOrFail($id);
    }

    public function getClassGroupById($id)
    {
        return ClassGroup::where('school_id', auth()->user()->school_id)->find($id);
    }

    public function getClassGroupByIdOrFail($id)
    {
        return ClassGroup::where('school_id', auth()->user()->school_id)->findOrFail($id);
    }

    public function createClass($record)
    {
        if (!$this->getClassGroupById($record['class_group_id'])) {
            return session()->flash('danger' ,__('Class group does not exists'));
        }

        $myClass =  MyClass::firstOrCreate($record);
        
        if (!$myClass->wasRecentlyCreated) {
            session()->flash('danger' ,__('Class already exists'));
        }else {
            session()->flash('success' ,__('Class created successfully'));
        }
        

        return $myClass;
    }

    public function createClassGroup($record)
    {
        $record['school_id'] = auth()->user()->school_id;

        $classGroup =  ClassGroup::firstOrCreate($record);
        
        if (!$classGroup->wasRecentlyCreated) {
            session()->flash('danger' ,__('Class group already exists'));
        }else {
            session()->flash('success' ,__('Class group created successfully'));
        }
        

        return $classGroup;
    }

    public function updateClass($id, $records)
    {
        $myClass = $this->getClassById($id);
        $myClass->update($records);
        session()->flash('success',  __('Class updated successfully'));

        return $myClass;
    }

    public function updateClassGroup($id, $records)
    {
        $classGroup = $this->getClassGroupById($id);
        $classGroup->update($records);
        session()->flash('success',  __('Class group updated successfully'));

        return $classGroup;
    }

    public function deleteClass()
    {
        return MyClass::delete();
    }

    public function deleteClassGroup($id)
    {
        $classGroup = $this->getClassGroupById($id);
        $classGroup->delete();
    }
}