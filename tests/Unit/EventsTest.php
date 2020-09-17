<?php

declare(strict_types=1);

namespace PersiLiao\Eventy\Test\Unit;

use PersiLiao\Eventy\Events;
use PHPUnit\Framework\TestCase;

use function json_encode;
use function PersiLiao\Eventy\addAction;
use function PersiLiao\Eventy\addFilter;
use function PersiLiao\Eventy\doAction;
use function PersiLiao\Eventy\getFilter;
use function PersiLiao\Eventy\removeFilter;

class EventsTest extends TestCase{

    protected $events;

    protected $post;

    public function testRemoveFilter()
    {
        addFilter('publish', function(){
            return true;
        });
        self::assertEquals(json_encode(getFilter()->getListeners()), '[{"hook":"publish","callback":{},"priority":10,"arguments":1}]');
        removeFilter('publish', function(){
            return true;
        });
        self::assertEquals(json_encode(getFilter()), '{}');
    }

    public function testDoAction()
    {
        addAction('publish', [
            $this,
            'addPost'
        ], 10, 2);
        doAction('publish', 'PersiLiao', 'Persi.Liao');
        self::assertEquals($this->post, [
            'title' => 'PersiLiao',
            'description' => 'Persi.Liao'
        ]);
    }

    public function testRemoveAllActions()
    {
        $this->events->addFilter('filter', [
            $this,
            'filterPost'
        ]);
    }

    public function testAddFilter()
    {

    }

    public function testRemoveAllFilters()
    {

    }

    public function testGetFilter()
    {

    }

    public function testRemoveAction()
    {

    }

    public function testApplyFilters()
    {

    }

    public function addPost($title, $description): void
    {
        if(!empty($title)){
            $this->post['title'] = $title;
        }
        if(!empty($title)){
            $this->post['description'] = $description;
        }
    }

    public function filterPost(array $post): void
    {
        if(isset($post['title'])){
            $post['title'] = '';
        }
        if(isset($post['description'])){
            $this->post['description'] = '';
        }
    }

    protected function setUp(): void
    {
        $this->events = new Events();
    }

}
