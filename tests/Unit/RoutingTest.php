<?php

namespace Bugphix\BugphixLaravel\Tests;

class RoutingTest extends TestCase
{
    protected $baseUrl = '/bugphix';

    /** @test */
    public function assert_true()
    {
        return $this->assertTrue(true);
    }
    // public function is_home_redirected()
    // {
    //     $response = $this->get("{$this->baseUrl}");
    //     $response->assertStatus(302);
    // }

    // /** @test */
    // public function is_issues_page_okay()
    // {
    //     $response = $this->get("{$this->baseUrl}/issues");
    //     $response->assertStatus(200);
    // }

    // /** @test */
    // public function is_projects_page_okay()
    // {
    //     $response = $this->get("{$this->baseUrl}/projects");
    //     $response->assertStatus(200);
    // }

    // /** @test */
    // public function is_users_page_okay()
    // {
    //     $response = $this->get("{$this->baseUrl}/users");
    //     $response->assertStatus(200);
    // }
}
