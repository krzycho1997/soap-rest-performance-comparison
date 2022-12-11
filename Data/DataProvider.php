<?php

require_once 'FinanceCourseDataMapper.php';

class DataProvider
{
    /** @return FinanceCourseDTO[] */
    public function getAllFinancialCoursesData(): array
    {
        $data = include '../../finance_courses_data.php';
        return FinanceCourseDataMapper::mapFromRowsToFinanceCourseArray($data);
    }
}
