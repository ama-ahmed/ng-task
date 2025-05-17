<?php

namespace core\Helpers;


trait HasRelationshipChecks
{
  public function hasRelationships(): bool
  {
    $hasRelations = false;

    if (!isset($this->relationsList)) return $hasRelations;
    foreach ($this->relationsList as $relation) {
      if (!$this->$relation()->get()->isEmpty()) {
        $hasRelations = true;
        if ($hasRelations) break;
      }
    }
    return $hasRelations;
  }

  protected static function bootHasRelationshipChecks()
  {
    static::deleting(function ($model) {
      $hasRelations = $model->hasRelationships();

      if ($hasRelations) {
        return false;
      }

      return true;
    });
  }
}
