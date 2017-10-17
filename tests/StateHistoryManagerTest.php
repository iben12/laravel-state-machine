<?php

namespace Sebdesign\SM\Test;

use Illuminate\Database\Eloquent\Model;
use Mockery;
use Sebdesign\SM\Services\StateHistoryManager;
use Sebdesign\SM\Test\Statable\StatableArticle;
use SM\Event\TransitionEvent;
use SM\StateMachine\StateMachine;

class StateHistoryManagerTest extends TestCase
{
    /**
     * @test
     */
    public function it_calls_models_history_storing_method()
    {
        // Arrange
        $model = Mockery::mock('model');
        $model->shouldReceive('addHistoryLine')->with([
            'transition' => 'foo',
            'to' => 'bar'
        ]);

        $sm = Mockery::mock('sm');
        $sm->shouldReceive('getObject')->andReturn($model);
        $sm->shouldReceive('getState')->andReturn('bar');

        $event = Mockery::mock(TransitionEvent::class);
        $event->shouldReceive('getStateMachine')->andReturn($sm);
        $event->shouldReceive('getTransition')->andReturn('foo');

        // Act
        $historyManager = app(StateHistoryManager::class);
        $historyManager->storeHistory($event);
    }
}