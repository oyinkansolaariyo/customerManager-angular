/**
 * Created by itunu.babalola on 2/9/17.
 */
 !function () {
    var app = angular.module('ContactApp.controllers');
    app.controller('UserController', [ 'UserService','MainService','ResponseService','$window','$timeout', function (UserService,MainService,ResponseService,$window,$timeout) {
     var vm = this;
     vm.new_todo = {};
     vm.addTodo = addTodo;
     vm.deleteTodo = deleteTodo;
     vm.updateStatus = updateStatus;
     vm.colors = [];
     vm.todos =[];

     $timeout(
         function () {
             getUserTodos();


         },10
     );

     function addTodo() {
         getColors();
         MainService.Modal().open('/app/templates/modal-templates/add_task.html',
             {
                 showDefaultButtons : true,
                 title: 'Add a new task',
                 mscope:vm

             },
             [
                 {
                    label: 'Add',
                     name: 'proceed',
                     onClick : function (params) {

                         UserService.addTodo({todo:vm.new_todo }).then(function (response) {
                             var resp = ResponseService.Brew(response);
                             if(resp.isOk()) {
                                 vm.todos = resp.getData();

                                $window.location.reload();

                                 MainService.Alert().open('Todo added successfully',{type:'success',autoClose :true, timeout : 7000});
                             }
                             else{
                                 MainService.Alert().open(resp.getError(),{type:'danger', autoClose: true, timeout :7000});
                             }
                         });
                     }

                 }
             ]
             );

     }

        function deleteTodo(todo_id) {
            getColors();
            MainService.Modal().open('/app/templates/modal-templates/confirm.html',
                {
                    showDefaultButtons : true,
                    title: 'Confirmation',
                    mscope:vm

                },
                [
                    {
                        label: 'Continue',
                        name: 'proceed',
                        onClick : function () {
                            UserService.deleteTodo({todo_id:todo_id}).then(function (response) {
                                var resp = ResponseService.Brew(response);
                                if(resp.isOk()) {
                                    $window.location.reload();

                                    MainService.Alert().open(resp.getData(),{type:'success',autoClose :true, timeout : 7000});
                                }
                                else{
                                    MainService.Alert().open(resp.getError(),{type:'danger', autoClose: true, timeout :7000});
                                }
                            });
                        }

                    }
                ]
            );

        }






        function updateStatus(todo_id,status_id) {
         console.log(todo_id);
         console.log(status_id);
            UserService.updateTodoStatus({todo_id:todo_id,status_id:status_id}).then(function (response) {
                var resp = ResponseService.Brew(response);
                if(resp.isOk()) {
                    $window.location.reload();

                    MainService.Alert().open(resp.getData(),{type:'success',autoClose :true, timeout : 7000});
                }
                else{
                    MainService.Alert().open(resp.getError(),{type:'danger', autoClose: true, timeout :7000});
                }
            });
        }


     function getColors() {
         UserService.getColors().then(function (response) {
             var resp = ResponseService.Brew(response);
             if(resp.isOk()) {
                 vm.colors = resp.getData();
             }
             else{
                 console.log(response.getError());
             }
         });
     }
        function getUserTodos() {
          UserService.getUserTodos().then(function (response) {
          var resp = ResponseService.Brew(response);
          if(resp.isOk()) {
              vm.todos = resp.getData();
          }
          else{

          }
      });
        }
    }


        
    ]);
}();