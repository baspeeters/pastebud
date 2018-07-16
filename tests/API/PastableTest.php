<?php

namespace App\Tests\API;

use App\Tests\RESTApiTestCase;

class PastableTest extends RESTApiTestCase
{
    const OBJECT_NAME = 'pastables';

    /** @test */
    public function it_lists_pastables()
    {
        // Given that we have some pastables
        $pastablesData = [
            ['name' => 'list-test-1', 'content' => 'Some content to list'],
            ['name' => 'list-test-2', 'content' => 'Also some content to list'],
        ];
        $this->post(self::OBJECT_NAME, $pastablesData[0]);
        $this->post(self::OBJECT_NAME, $pastablesData[1]);

        // And we call the endpoint for listing pastables
        $response = $this->list(self::OBJECT_NAME);

        // It should return a 200 response with the created objects
        $arrayResponseBody = self::getArrayResponseBody($response);
        self::assertEquals(200, $response->code);
        self::assertCount(2, $arrayResponseBody);
        self::assertArraySubset($pastablesData[0], $arrayResponseBody[0]);
        self::assertArraySubset($pastablesData[1], $arrayResponseBody[1]);
    }

    /** @test */
    public function it_creates_a_pastable_with_valid_input()
    {
        // When we call the endpoint to create a pastable
        $data = [
            'name' => 'create-test',
            'content' => 'Test to create a pastable',
        ];
        $response = $this->post(self::OBJECT_NAME, $data);
        $arrayResponseBody = self::getArrayResponseBody($response);

        // It should return a 201 response with the created object
        self::assertEquals(201, $response->code);
        self::assertArraySubset($data, $arrayResponseBody);
    }

    /** @test */
    public function it_does_not_create_a_pastable_with_invalid_input()
    {
        // Given that we invalid input data for a pastable
        $dataForCreate = [
            'name' => 1,
            'content' => 1,
        ];

        // Then when we call the create endpoint with that data
        $response = $this->post(self::OBJECT_NAME, $dataForCreate);

        // It should return a 400 response
        self::assertEquals(400, $response->code);
    }

    /** @test */
    public function it_gets_a_pastable()
    {
        // Given that we have a pastable
        $dataForCreate = [
            'name' => 'get-test',
            'content' => 'Test to get a pastable',
        ];
        $responseForCreate = $this->post(self::OBJECT_NAME, $dataForCreate);

        // Then when we request to get the pastable
        $responseForGet = $this->get(self::OBJECT_NAME, $responseForCreate->body->id);
        $arrayResponseBodyForGet = self::getArrayResponseBody($responseForGet);

        // It should return a 200 response with the requested object
        self::assertEquals(200, $responseForGet->code);
        self::assertArraySubset($dataForCreate, $arrayResponseBodyForGet);
    }

    /** @test */
    public function it_edits_pastables()
    {
        // Given that we have a pastable
        $dataForCreate = [
            'name' => 'edit-test',
            'content' => 'Test to edit a pastable',
        ];
        $responseForCreate = $this->post(self::OBJECT_NAME, $dataForCreate);
        $arrayResponseBodyForCreate = self::getArrayResponseBody($responseForCreate);

        // And we call the endpoint to edit the pastable
        $dataForEdit = [
            'name' => 'edit-test-edited',
            'content' => 'Test to edit a pastable (this has been edited now)',
        ];
        $dataForEditWithId = $dataForEdit + $arrayResponseBodyForCreate;
        $responseForEdit = $this->put(self::OBJECT_NAME, $responseForCreate->body->id, $dataForEdit);
        $arrayResponseBodyForEdit = self::getArrayResponseBody($responseForEdit);

        // It should give a 200 response with the edited object
        self::assertEquals(200, $responseForEdit->code);
        self::assertEquals($dataForEditWithId, $arrayResponseBodyForEdit);

        // Then when we call the endpoint to get the object
        $responseForGet = $this->get(self::OBJECT_NAME, $responseForCreate->body->id);
        $arrayResponseBodyForGet = self::getArrayResponseBody($responseForGet);

        // It should return a 200 response with the edited object containing the edited values
        self::assertEquals(200, $responseForGet->code);
        self::assertEquals($dataForEditWithId, $arrayResponseBodyForGet);
        self::assertEquals($dataForCreate, array_diff($arrayResponseBodyForCreate, $arrayResponseBodyForGet));
    }

    /** @test */
    public function it_deletes_pastables()
    {
//        self::markTestIncomplete();

        // Given that we have a pastable
        $responseForCreate = $this->post(self::OBJECT_NAME, [
            'name' => 'delete-test',
            'content' => 'Test to delete a pastable',
        ]);

        // And we call the endpoint to delete that pastable
        $responseForDelete = self::delete(self::OBJECT_NAME, $responseForCreate->body->id);

        // It should return a response with a 204 code
        self::assertEquals(204, $responseForDelete->code);

        // Then when we call the endpoint to get the pastable
        $responseForGet = $this->get(self::OBJECT_NAME, $responseForCreate->body->id);

        // It should return a 404 response
        self::assertEquals(404, $responseForGet->code);
    }
}
