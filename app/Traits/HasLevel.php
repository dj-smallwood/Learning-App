<?php

namespace App\Traits;

trait HasLevel
{
    public function getLevel()
    {
        $points = $this->points;

        return match(true) {
            $points >= 10001 => ['name' => 'God', 'color' => 'text-purple-600'],
            $points >= 5501 => ['name' => 'Legend', 'color' => 'text-red-600'],
            $points >= 3501 => ['name' => 'Champion', 'color' => 'text-yellow-600'],
            $points >= 2001 => ['name' => 'Warrior', 'color' => 'text-blue-600'],
            $points >= 1001 => ['name' => 'Adventurer', 'color' => 'text-green-600'],
            $points >= 251 => ['name' => 'Apprentice', 'color' => 'text-gray-600'],
            default => ['name' => 'Noob', 'color' => 'text-gray-400'],
        };
    }

    public function getNextLevelPoints()
    {
        $points = $this->points;

        return match(true) {
            $points >= 10001 => null,
            $points >= 5501 => 10001,
            $points >= 3501 => 5501,
            $points >= 2001 => 3501,
            $points >= 1001 => 2001,
            $points >= 251 => 1001,
            default => 251,
        };
    }

    public function getLevelProgress()
    {
        if ($this->points >= 10001) {
            return 100;
        }

        $currentLevel = match(true) {
            $this->points >= 5501 => 5501,
            $this->points >= 3501 => 3501,
            $this->points >= 2001 => 2001,
            $this->points >= 1001 => 1001,
            $this->points >= 251 => 251,
            default => 0,
        };

        $nextLevel = $this->getNextLevelPoints();
        $pointsInCurrentLevel = $this->points - $currentLevel;
        $pointsNeededForNextLevel = $nextLevel - $currentLevel;

        return round(($pointsInCurrentLevel / $pointsNeededForNextLevel) * 100);
    }

    public function checkLevelUp($oldPoints)
    {
        $oldLevel = match(true) {
            $oldPoints >= 10001 => 'God',
            $oldPoints >= 5501 => 'Legend',
            $oldPoints >= 3501 => 'Champion',
            $oldPoints >= 2001 => 'Warrior',
            $oldPoints >= 1001 => 'Adventurer',
            $oldPoints >= 251 => 'Apprentice',
            default => 'Noob',
        };

        $newLevel = $this->getLevel()['name'];

        if ($newLevel !== $oldLevel) {
            return [
                'level' => $newLevel,
                'color' => $this->getLevel()['color']
            ];
        }

        return null;
    }
} 