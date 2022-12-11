<?php

require_once 'AdditionalInfoFinanceCourseDTO.php';

class FinanceCourseDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $url,
        public readonly bool $isPaid,
        public readonly string $price,
        public readonly AdditionalInfoFinanceCourseDTO $additionalInfoFinanceCourseDTO,
        public readonly string $publishedTime,
    )
    {
    }
}
