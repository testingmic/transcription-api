<?php

namespace App\Controllers\Tickets;

use App\Controllers\LoadController;
use App\Libraries\Routing;

class Tickets extends LoadController {

    /**
     * View a ticket
     * 
     * @return array
     */
    public function list() {

        $payload = [
            'user_id' => $this->currentUser['id'],
            'status' => $this->payload['status'] ?? null,
            'type' => $this->payload['type'] ?? null,
            'priority' => $this->payload['priority'] ?? null,
            'subject' => $this->payload['subject'] ?? null,
            'description' => $this->payload['description'] ?? null,
        ];

        if($this->isUser()) {
            $payload['user_id'] = $this->currentUser['id'];
        }

        $ticket = $this->ticketsModel->listTickets($payload, $this->payload['limit'] ?? 10, $this->payload['offset'] ?? 0);

        return Routing::success($ticket);
    }

    /**
     * View a ticket
     * 
     * @return array
     */
    public function view() {

        if(empty($this->uniqueId)) {
            return Routing::error('Ticket ID is required');
        }

        $payload = ['id' => $this->uniqueId];
        if($this->isUser()) {
            $payload['user_id'] = $this->currentUser['id'];
        }

        $ticket = $this->ticketsModel->checkExists($payload);
        if(empty($ticket)) {
            return Routing::error('Ticket not found');
        }

        $ticket['messages'] = $this->ticketsModel->listMessages(['ticket_id' => $this->uniqueId]);
        if(empty($ticket['messages'])) {
            $ticket['messages'] = [];
        }

        return Routing::success($ticket);
    }

    /**
     * List tickets
     * 
     * @return array
     */
    public function create() {

        $payload = [
            'user_id' => $this->currentUser['id'],
            'subject' => $this->payload['subject'],
            'description' => $this->payload['description'],
            'priority' => $this->payload['priority'],
            'type' => $this->payload['type'],
            'user_id' => $this->currentUser['id'],
            'status' => 'open',
        ];

        $ticket = $this->ticketsModel->createTicket($payload);
        if(empty($ticket)) {
            return Routing::error('Failed to create ticket');
        }

        $this->uniqueId = $ticket;

        return Routing::created([
            'data' => 'Ticket created successfully', 
            'record' => $this->view()['data']
        ]);

    }

    /**
     * Update a ticket
     * 
     * @return array
     */
    public function update() {

        if(empty($this->uniqueId)) {
            return Routing::error('Ticket ID is required');
        }
        
        $payload = ['id' => $this->uniqueId];
        if($this->isUser()) {
            $payload['user_id'] = $this->currentUser['id'];
        }

        $ticket = $this->ticketsModel->checkExists($payload);
        if(empty($ticket)) {
            return Routing::error('Ticket not found');
        }

        $ticket = $this->ticketsModel->updateTicket($this->uniqueId, $this->payload);
        if(empty($ticket)) {
            return Routing::error('Failed to update ticket');
        }

        return Routing::updated('Ticket updated successfully', $this->view()['data']);

    }

    /**
     * Create a message for a ticket
     * 
     * @return array
     */
    public function messages() {

        if(empty($this->uniqueId)) {
            return Routing::error('Ticket ID is required');
        }

        $payload = ['id' => $this->uniqueId];
        $ticketRecord = $this->ticketsModel->checkExists($payload);
        if(empty($ticketRecord)) {
            return Routing::notFound('Ticket');
        }

        $payload = [
            'ticket_id' => $this->uniqueId,
            'user_id' => $this->currentUser['id'],
            'message' => $this->payload['message'],
            'sender_type' => $this->isUser() ? 'user' : 'admin',
        ];

        $message = $this->ticketsModel->createMessage($payload);
        if(empty($message)) {
            return Routing::error('Failed to create message');
        }

        $updated = ['messages_count' => $ticketRecord['messages_count'] + 1];

        // change the status to in progress if the user is an admin
        if($this->isAdmin()) {
            $updated['status'] = 'in_progress';
        }

        $this->ticketsModel->updateTicket($this->uniqueId, $updated);

        return Routing::created(['data' => 'Message created successfully', 'record' => $this->view()['data']]);

    }

    /**
     * Close a ticket
     * 
     * @return array
     * 
     * @return array
     */
    public function close() {
        $this->payload['status'] = 'closed';
        return $this->update();
    }

    /**
     * Close a ticket
     * 
     * @return array
     * 
     * @return array
     */
    public function status() {
        return $this->update();
    }

}