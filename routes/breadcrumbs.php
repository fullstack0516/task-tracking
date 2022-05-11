<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});

// Dashboard > Profile
Breadcrumbs::for('profile.show', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Profile', route('profile.show'));
});

// Dashboard > Teams
Breadcrumbs::for('teams.show', function (BreadcrumbTrail $trail, $team) {
    $trail->parent('dashboard');
    $trail->push('Teams', route('teams.show', $team));
});

// Dashboard > CRM
Breadcrumbs::for('crm.dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('CRM', route('crm.dashboard'));
});

// Dashboard > CRM > Prospects
Breadcrumbs::for('crm.prospects.index', function (BreadcrumbTrail $trail) {
    $trail->parent('crm.dashboard');
    $trail->push('Prospects', route('crm.prospects.index'));
});

// CRM > Prospects > [Show]
Breadcrumbs::for('crm.prospects.show', function (BreadcrumbTrail $trail, $prospect) {
    $trail->parent('crm.prospects.index');
    $trail->push($prospect->company, route('crm.prospects.show', $prospect));
});

// Dashboard > Projects
Breadcrumbs::for('projects.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Projects', route('projects.index'));
});

// Dashboard > Projects > [Project]
Breadcrumbs::for('projects.overview', function (BreadcrumbTrail $trail, $project) {
    $trail->parent('projects.index');
    $trail->push($project->name, route('projects.overview', $project));
});

// Dashboard > Clients
Breadcrumbs::for('clients.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Clients', route('clients.index'));
});

// Dashboard > Clients > [Client]
Breadcrumbs::for('clients.show', function (BreadcrumbTrail $trail, $client) {
    $trail->parent('clients.index');
    $trail->push($client->company, route('clients.show', $client));
});

// Dashboard > Credentials
Breadcrumbs::for('credentials.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Credentials', route('credentials.index'));
});

// Dashboard > Time Entries
Breadcrumbs::for('time-entries.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Time Entries', route('time-entries.index'));
});
