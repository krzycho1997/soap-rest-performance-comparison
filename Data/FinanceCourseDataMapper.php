<?php

require_once 'Model/FinanceCourseDTO.php';
require_once 'Model/AdditionalInfoFinanceCourseDTO.php';

class FinanceCourseDataMapper
{
    private function __construct()
    {
    }

    /** @param FinanceCourseDTO[] $data */
    public static function mapFromRowsToFinanceCourseArray(array $data): array
    {
        return array_map(fn(array $row) => self::mapToFinanceCourse($row), $data);
    }

    public static function mapToFinanceCourse(array $row): FinanceCourseDTO
    {
        return new FinanceCourseDTO(
            $row['id'] ?? 0,
            $row['title'] ?? '-',
            $row['url'] ?? '-',
            $row['isPaid'] ?? false,
            $row['price'] ?? '-',
            new AdditionalInfoFinanceCourseDTO(
                $row['numSubscribers'] ?? '0',
                    $row['numReviews'] ?? '0',
                    $row['numPublishedLectures'] ?? 0,
                    $row['instructionalLevel'] ?? '-',
                    $row['contentInfo'] ?? '-',
            ),
            $row['publishedTime'] ?? '-',
        );
    }
}
