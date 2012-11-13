<?php

namespace Agile\NimbleBoardBundle\Constants;

class StoryStatus
{
  const STATUS_TODO = 0;
  const STATUS_INPROGRESS = 1;
  const STATUS_DONE = 2;

  const TEXT_TODO = 'storystatus.todo';
  const TEXT_INPROGRESS = 'storystatus.inprogress';
  const TEXT_DONE = 'storystatus.done';

  public static function getStatuses() {
    return array(
      StoryStatus::STATUS_TODO => StoryStatus::TEXT_TODO,
      StoryStatus::STATUS_INPROGRESS => StoryStatus::TEXT_INPROGRESS,
      StoryStatus::STATUS_DONE => StoryStatus::TEXT_DONE,
    );
  }
}
