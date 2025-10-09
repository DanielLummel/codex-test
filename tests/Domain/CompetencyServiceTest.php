<?php

namespace Tests\Domain;

use App\Domain\Model\Project;
use App\Domain\Model\ProjectStatus;
use App\Domain\Model\Skill;
use App\Domain\Model\TeamMember;
use App\Domain\Model\WorkPackage;
use App\Domain\Model\Task;
use App\Domain\Service\CompetencyService;
use App\Infrastructure\Repository\InMemory\InMemoryTeamMemberRepository;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class CompetencyServiceTest extends TestCase
{
    public function test_it_generates_competency_matrix_sorted_by_skill(): void
    {
        $repository = new InMemoryTeamMemberRepository();
        $anna = new TeamMember('m1', 'Anna Schmidt', 'Backend Entwicklerin');
        $anna->addSkill(new Skill('PHP', 5));
        $anna->addSkill(new Skill('Datenbanken', 4));
        $repository->save($anna);

        $max = new TeamMember('m2', 'Max Müller', 'Frontend Entwickler');
        $max->addSkill(new Skill('Vue.js', 5));
        $max->addSkill(new Skill('PHP', 3));
        $max->markAvailability(false);
        $repository->save($max);

        $service = new CompetencyService($repository);

        $matrix = $service->generateMatrix();

        self::assertSame('Datenbanken', $matrix->rows[0]['skill']);
        self::assertCount(2, $matrix->rows);
        self::assertSame('Anna Schmidt', $matrix->rows[1]['members'][0]['name']);
        self::assertFalse($matrix->rows[1]['members'][1]['available']);
    }

    public function test_it_detects_skill_gaps_for_project(): void
    {
        $repository = new InMemoryTeamMemberRepository();
        $anna = new TeamMember('m1', 'Anna Schmidt', 'Backend Entwicklerin');
        $anna->addSkill(new Skill('PHP', 5));
        $repository->save($anna);

        $service = new CompetencyService($repository);

        $project = new Project(
            'project-1',
            'Marketing Plattform',
            'ACME AG',
            ProjectStatus::Draft,
            new DateTimeImmutable('2024-01-01')
        );

        $workPackage = new WorkPackage('WP-01', 'Implementierung', 'Technische Umsetzung');
        $workPackage->addTask(new Task('Backend', 'Implementierung Backend', 80, ['PHP', 'MySQL']));
        $project->addWorkPackage($workPackage);

        $gap = $service->analyzeProject($project);

        self::assertFalse($gap->rows[0]['missing']);
        self::assertTrue($gap->rows[1]['missing']);
        self::assertSame('MySQL', $gap->rows[1]['skill']);
    }
}
