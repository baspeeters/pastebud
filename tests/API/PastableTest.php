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
        $responseForList = $this->list(self::OBJECT_NAME);

        // It should return a 200 response with the created objects
        self::assertEquals(200, $this->client->getResponse()->getStatusCode());
        self::assertCount(2, $responseForList);
        self::assertArraySubset($pastablesData[0], $responseForList[0]);
        self::assertArraySubset($pastablesData[1], $responseForList[1]);
    }

    /** @test */
    public function it_creates_a_pastable_with_valid_input()
    {
        // When we call the endpoint to create a pastable
        $data = [
            'name' => 'create-test',
            'content' => 'Test to create a pastable',
        ];
        $responseForCreate = $this->post(self::OBJECT_NAME, $data);

        // It should return a 201 response with the created object
        self::assertEquals(201, $this->client->getResponse()->getStatusCode());
        self::assertArraySubset($data, $responseForCreate);
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
        $this->post(self::OBJECT_NAME, $dataForCreate);

        // It should return a 400 response
        self::assertEquals(400, $this->client->getResponse()->getStatusCode());
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
        self::arrayHasKey('id', $responseForCreate);
        $responseForGet = $this->get(self::OBJECT_NAME, $responseForCreate['id']);

        // It should return a 200 response with the requested object
        self::assertEquals(200, $this->client->getResponse()->getStatusCode());
        self::assertArraySubset($dataForCreate, $responseForGet);
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

        // And we call the endpoint to edit the pastable
        $dataForEdit = [
            'name' => 'edit-test-edited',
            'content' => 'Test to edit a pastable (this has been edited now)',
        ];
        $dataForEditWithId = $dataForEdit + $responseForCreate;
        self::arrayHasKey('id', $responseForCreate);
        $responseForEdit = $this->put(self::OBJECT_NAME, $responseForCreate['id'], $dataForEdit);

        // It should give a 200 response with the edited object
        self::assertEquals(200, $this->client->getResponse()->getStatusCode());
        self::assertEquals($dataForEditWithId, $responseForEdit);

        // Then when we call the endpoint to get the object
        $responseForGet = $this->get(self::OBJECT_NAME, $responseForCreate['id']);

        // It should return a 200 response with the edited object containing the edited values
        self::assertEquals(200, $this->client->getResponse()->getStatusCode());
        self::assertEquals($dataForEditWithId, $responseForGet);
        self::assertEquals($dataForCreate, array_diff($responseForCreate, $responseForGet));
    }

    /** @test */
    public function it_deletes_pastables()
    {
        // Given that we have a pastable
        $responseForCreate = $this->post(self::OBJECT_NAME, [
            'name' => 'delete-test',
            'content' => 'Test to delete a pastable',
        ]);

        // And we call the endpoint to delete that pastable
        self::arrayHasKey('id', $responseForCreate);
        $this->delete(self::OBJECT_NAME, $responseForCreate['id']);

        // It should return a response with a 204 code
        self::assertEquals(204, $this->client->getResponse()->getStatusCode());

        // Then when we call the endpoint to get the pastable
        $this->get(self::OBJECT_NAME, $responseForCreate['id']);

        // It should return a 404 response
        self::assertEquals(404, $this->client->getResponse()->getStatusCode());
    }
}
