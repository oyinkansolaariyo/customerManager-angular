<?php
// Routes
//$app->get('/{path:(?!(?:login)(?:logout)(?:signup)).*}', '\Controllers\IndexController:index');
$app->get('/login', '\Controllers\UserController:index')->add(new \Middleware\LayoutMw($container));
$app->get('/register','\Controllers\UserController:register')->add(new \Middleware\LayoutMw($container));
$app->get('/logout','\Controllers\UserController:logout');

$app->group('/api', function() use ($app, $container) {
    $app->post('/login', '\Controllers\UserController:loginHandler');
    $app->post('/register', '\Controllers\UserController:creationHandler');
    $app->group('/', function() use ($app, $container) {
        //post endpoints
        $app->post('add_customer','\Controllers\CustomerController:addCustomer');
        $app->post('add_todo','\Controllers\TodoController:addNewTodo');

        $app->post('customer/{customer_id}/delete','\Controllers\CustomerController:deleteCustomer');
        $app->post('update_customer','\Controllers\CustomerController:updateCustomer');
        $app->post('customer/{customer_id}/add_conversation','\Controllers\ConversationController:addConversation');
        $app->post('customer/{customer_id}/update_conversation','\Controllers\ConversationController:updateConversation');
        $app->post('conversation/{conversation_id}/add_detail','\Controllers\ConversationDetailController:addDetail');
        $app->post('conversation/{conversation_id}/update_detail','\Controllers\ConversationDetailController:updateDetail');
        $app->post('conversation/{conversation_id}/category_conversation_details','\Controllers\ConversationDetailController:getDetailsByCategory');
        $app->post('conversation/{conversation_id}/bulk_delete','\Controllers\ConversationDetailController:bulkDeleteDetails');
        $app->post('conversation/{conversation_id}/bulk_update','\Controllers\ConversationDetailController:bulkUpdateDetailsCategory');
        $app->post('conversation/{conversation_id}/book_appointment','\Controllers\AppointmentController:bookAppointment');
        $app->post('conversation/{conversation_id}/all_conversation_appointments','\Controllers\AppointmentController:allAppointments');
        $app->post('conversation/{conversation_id}/update_appointment_status','\Controllers\AppointmentController:updateAppointment');
        $app->post('todo/{todo_id}/delete','\Controllers\TodoController:deleteTodo');
        $app->post('todo/{todo_id}/update','\Controllers\TodoController:UpdateStatus');

        //get endpoints
        $app->get('get_customer','\Controllers\CustomerController:getAllCustomers');
        $app->get('customer/{customer_id}/details','\Controllers\CustomerController:getCustomerDetails');
        $app->get('customer/{customer_id}/get_no_of_conversations','\Controllers\CustomerController:getNoOfConversations');
        $app->get('customer/{customer_id}/get_conversation','\Controllers\ConversationController:getCustomerConversations');
        $app->get('conversation/{conversation_id}/details','\Controllers\ConversationController:getConversation');
        $app->get('conversation/{conversation_id}/conversation_details','\Controllers\ConversationDetailController:getConversationDetails');
        $app->get('categories','\Controllers\CategoryController:getAllCategories');
        $app->get('colors','\Controllers\ColorController:getColors');
        $app->get('get_user_todos','\Controllers\TodoController:getUserTodos');
        $app->get('get_no_todos','\Controllers\TodoController:numberOfTodos');
        $app->get('get_no_appointments','\Controllers\AppointmentController:numberOfAppointments');
        $app->get('get_no_conversations','\Controllers\ConversationController:numberOfConversations');
        $app->get('get_no_customers','\Controllers\CustomerController:numberOfCustomers');
    })->add(new \Middleware\AuthMW($container));
});

$app->get('/{path:(?!(?:login)(?:logout)(?:register)).*}', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");
    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
})->add(new \Middleware\AuthMW($container));

