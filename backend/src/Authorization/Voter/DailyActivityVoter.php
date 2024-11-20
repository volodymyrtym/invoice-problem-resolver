<?php

declare(strict_types=1);

namespace App\Authorization\Voter;


use App\Authorization\Enum\PermissionDomainsEnum;
use App\Authorization\PermissionRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * coupling is neccessary, no real auth priviliges yet done or needed
 */
final class DailyActivityVoter extends Voter
{
    private const string PREFIX = PermissionDomainsEnum::DailyActivity->value;
    public const string READ = self::PREFIX . 'read';
    public const string UPDATE = self::PREFIX . 'update';
    public const string CREATE = self::PREFIX . 'create';
    public const string DELETE = self::PREFIX . 'delete';
    public const string READ_LIST = self::PREFIX . 'read_list';

    public function __construct(private PermissionRepository $permissionRepository) {}

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::CREATE, self::READ, self::UPDATE, self::DELETE, self::READ_LIST], true);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($attribute === self::READ_LIST || $attribute === self::CREATE) {
            return true;
        }

        if (!is_string($subject)) {
            throw new \InvalidArgumentException('Subject cannot be empty');
        }

        return $this->permissionRepository->hasAllPermission(
            domain: PermissionDomainsEnum::DailyActivity,
            subjectId: $subject,
            userId: $user->getUserIdentifier(),
        );
    }
}
