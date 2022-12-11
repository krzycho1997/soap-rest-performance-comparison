<?php

class AdditionalInfoFinanceCourseDTO
{
    public function __construct(
        public readonly string $numSubscribers,
        public readonly string $numReviews,
        public readonly int $numPublishedLectures,
        public readonly string $instructionalLevel,
        public readonly string $contentInfo,
    )
    {
    }
}
