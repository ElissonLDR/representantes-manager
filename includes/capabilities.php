<?php

if (!defined('ABSPATH')) exit;

if (!defined('RM_CAP')) {
    define('RM_CAP', 'manage_representantes');
}

function rm_user_can_manage() {
    return current_user_can(RM_CAP);
}

function rm_grant_default_caps() {
    $role = get_role('administrator');

    if ($role && !$role->has_cap(RM_CAP)) {
        $role->add_cap(RM_CAP);
    }
}

function rm_register_members_cap_group() {
    if (!function_exists('members_register_cap_group')) {
        return;
    }

    members_register_cap_group('representantes-manager', [
        'label'    => __('Representantes Manager', 'representantes-manager'),
        'caps'     => [RM_CAP],
        'icon'     => 'dashicons-groups',
        'priority' => 30,
    ]);
}

function rm_register_members_cap() {
    if (!function_exists('members_register_cap')) {
        return;
    }

    members_register_cap(RM_CAP, [
        'label' => __('Gerenciar representantes e cidades', 'representantes-manager'),
        'group' => 'representantes-manager',
    ]);
}

add_action('init', 'rm_grant_default_caps', 5);

add_action('members_register_cap_groups', 'rm_register_members_cap_group');
add_action('members_register_caps', 'rm_register_members_cap');
