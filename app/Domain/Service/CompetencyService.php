<?php

namespace App\Domain\Service;

use App\Domain\DTO\CompetencyMatrix;
use App\Domain\DTO\SkillGap;
use App\Domain\Model\Project;
use App\Domain\Model\Skill;
use App\Domain\Model\TeamMember;
use App\Domain\Repository\TeamMemberRepository;

final class CompetencyService
{
    public function __construct(private readonly TeamMemberRepository $teamMemberRepository)
    {
    }

    public function registerSkill(string $memberId, Skill $skill): void
    {
        $member = $this->teamMemberRepository->find($memberId);
        if (! $member instanceof TeamMember) {
            $member = new TeamMember($memberId, 'Unbekannt', 'Unbekannt');
        }

        $member->addSkill($skill);
        $this->teamMemberRepository->save($member);
    }

    public function generateMatrix(): CompetencyMatrix
    {
        $rows = [];
        $skillsIndex = [];

        foreach ($this->teamMemberRepository->all() as $member) {
            foreach ($member->skills() as $skill) {
                $key = strtolower($skill->name());
                if (! isset($skillsIndex[$key])) {
                    $skillsIndex[$key] = [
                        'skill' => $skill->name(),
                        'members' => [],
                    ];
                }

                $skillsIndex[$key]['members'][] = [
                    'name' => $member->name(),
                    'proficiency' => $skill->proficiency(),
                    'available' => $member->isAvailable(),
                    'role' => $member->role(),
                ];
            }
        }

        foreach ($skillsIndex as $row) {
            usort($row['members'], static fn (array $a, array $b): int => $b['proficiency'] <=> $a['proficiency']);
            $rows[] = $row;
        }

        usort($rows, static fn (array $a, array $b): int => strcmp($a['skill'], $b['skill']));

        return new CompetencyMatrix($rows);
    }

    public function analyzeProject(Project $project): SkillGap
    {
        $rows = [];
        $availableMembers = $this->teamMemberRepository->all();

        foreach ($project->requiredSkills() as $skillName) {
            $suggested = [];
            foreach ($availableMembers as $member) {
                foreach ($member->skills() as $skill) {
                    if (strcasecmp($skill->name(), $skillName) === 0 && $member->isAvailable()) {
                        $suggested[] = sprintf('%s (%s)', $member->name(), $member->role());
                    }
                }
            }

            $rows[] = [
                'skill' => $skillName,
                'missing' => $suggested === [],
                'suggestedMembers' => $suggested,
            ];
        }

        usort($rows, static fn (array $a, array $b): int => strcmp($a['skill'], $b['skill']));

        return new SkillGap($rows);
    }
}
