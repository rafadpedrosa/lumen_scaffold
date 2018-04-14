<?php

use App\Http\Models\{template};
use \Laravel\Lumen\Testing\DatabaseMigrations;

class {template}Test extends TestCase
{
    private ${ltemplate};
    private $lastIdInserted;

    public function setUp()
    {
        parent::setUp();
        $this->{ltemplate} = factory({template}::class)->make();
        try {
            $this->lastIdInserted = {template}::withTrashed()->orderBy('id')->get()->last()->id;
        } catch (Exception $e) {
            $this->lastIdInserted = 0;
        }
    }

    /**
     * should test required fields {ltemplate}.
     *
     * @return void
     */
    public function testShouldTestRequiredFiled{template}()
    {
        $this->json('POST', '/api/{ltemplate}', [])
            ->seeJson([
                'name' => ["The name field is required."]
            ]);
    }

    /**
     * should test create {ltemplate}.
     *
     * @return void
     */
    public function testShouldTestCreate{template}()
    {
        $expect = $this->lastIdInserted + 1;
        $this->json('POST', '/api/{ltemplate}', $this->{ltemplate}->toArray())
            ->seeJson(['id' => $expect]);
    }

    /**
     * should test update {ltemplate}.
     *
     * @return void
     */
    public function testShouldUpdate{template}()
    {
        $update{template} = factory({template}::class)->make();
        $this->json('PUT', '/api/{ltemplate}/' . $this->lastIdInserted, $update{template}->toArray())
            ->dontSeeJson(['name' => $this->{ltemplate}->name])
            ->seeJson(['name' => $update{template}->name]);
    }

    /**
     * should test delete {ltemplate}.
     *
     * @return void
     */
    public function testShouldTestDelete{template}()
    {
        $expect = ["DESTROY " => $this->lastIdInserted . ""];
        $this->json('DELETE', '/api/{ltemplate}/' . $this->lastIdInserted)
            ->seeJson($expect);
    }
}
