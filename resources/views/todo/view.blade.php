@extends('layouts.app')

@section('style')
<style>
.trash { color:rgb(209, 91, 71); }
.flag { color:rgb(248, 148, 6); }
.panel-body { padding:0px; }
.panel-footer .pagination { margin: 0; }
.panel .glyphicon,.list-group-item .glyphicon { margin-right:5px; }
.panel-body .radio, .checkbox { display:inline-block;margin:0px; }
.panel-body input[type=checkbox]:checked + label { text-decoration: line-through;color: rgb(128, 144, 160); }
.list-group-item:hover, a.list-group-item:focus {text-decoration: none;background-color: rgb(245, 245, 245);}
.list-group { margin-bottom:0px; }
.checkbox input[type=checkbox], .checkbox-inline input[type=checkbox], .radio input[type=radio], .radio-inline input[type=radio] { margin-left:0px; }
</style>
@stop


@section('content')

    <br><br>

    <div id="app" class="col-sm-6 col-sm-offset-3">
        

        <div class="panel-body">
            
            <input type="text" class="form-control" placeholder="Add Todo List" v-model="todoValue" v-on:keyup.enter="setTodoList">
            
            <ul class="list-group" v-if="todoList.length != 0">
                
                <li class="list-group-item" v-for="(record, index) in todoList" v-show="sectionOne">
                    
                    <div class="checkbox"  v-if="record.id != editTodoId">
                        <input type="checkbox" v-bind:id="record.id" class="checkbox checkbox-circle" v-on:click="deleteAction(record.id, record.name)"/>
                        <label v-on:click="editAction(record.id, record.name)">
                            @{{ record.name }}
                        </label>
                    </div>
                    
                    <input type="text" class="form-control" v-model="editTodoValue" v-if="record.id == editTodoId" v-on:keyup.enter="setUpdateTodoList">
                
                </li>

                <li class="list-group-item" v-show="sectionTwo">
                    <div class="checkbox">
                        <input id="checkbox" type="checkbox" class="checkbox checkbox-circle" checked=""/>
                        <label>@{{ deleteValue }}</label>
                    </div>
                </li>

                <li class="list-group-item">
                    <div class="checkbox">
                        <a href="javascript:void(0)" v-on:click="allButton()">All</a>
                        <a href="javascript:void(0)" v-on:click="actionButton()">Active</a>
                        <a href="javascript:void(0)" v-on:click="completeButton()">Completed</a>
                    </div>
                </li>
            
            </ul>
        
        </div>
    
    </div>
    
@stop

@section('script')

    <script src="https://unpkg.com/vue@2.6.11/dist/vue.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script>
        new Vue({
            el: '#app',
            data: {
                todoValue: '',
                editTodoValue: '',
                editTodoId: 0,
                deleteTodoValue: '',
                deleteTodoId: 0,
                todoList: [],
                sectionOne: true,
                sectionTwo: false,
                deleteValue: '',
                activeOn: false
            },

            created: function () {
                
                let vm = this;

                axios.get("api/todoList")
                    .then(function(response) {
                       
                        if(response.data.status == true)
                           vm.todoList = response.data.data;
                    
                    })
                    .catch(function(err) {
                       console.log(err);
                    })
            },

            methods: {

                setTodoList: function ()
                {   
                    let vm = this,
                        lastRecord,
                        lastId,
                        setArr = [];
                        
                    if(vm.todoList.length == 0) 
                        lastId = 1;
                    else 
                    {   
                        lastRecord = vm.todoList[vm.todoList.length - 1];
                        lastId = lastRecord.id + 1;
                    }

                    setArr['id'] = lastId;
                    setArr['name'] = vm.todoValue;

                    vm.todoList.push(setArr);
                    vm.todoValue = '';

                    // console.log(vm.todoList);
                },

                editAction: function (id, name)
                {   
                    let vm = this;
                    
                    vm.editTodoValue = name;
                    vm.editTodoId = id;
                },

                setUpdateTodoList: function () 
                {   
                    let vm = this;

                    for(i=0; i<vm.todoList.length; i++)
                    {
                        if(vm.editTodoId == vm.todoList[i].id && vm.editTodoValue != vm.todoList[i].name)
                            vm.todoList[i].name = vm.editTodoValue;
                    }

                    vm.editTodoValue = '';
                    vm.editTodoId = 0;

                    // console.log(vm.todoList);
                },

                deleteAction: function (id, name) 
                {
                    let vm = this;

                    vm.deleteTodoValue = name;
                    vm.deleteTodoId = id;
                },

                allButton: function () 
                {
                    let vm = this;

                    vm.sectionOne = true;
                    vm.sectionTwo = false;

                    axios.get("api/todoList")
                        .then(function(response) {
                           
                            if(response.data.status == true)
                               vm.todoList = response.data.data;
                        
                        })
                        .catch(function(err) {
                           console.log(err);
                        })
                },

                actionButton: function () 
                {
                    let vm = this;

                    if(vm.deleteTodoId != 0)
                    {
                        for(i=0; i<vm.todoList.length; i++)
                        {
                            if(vm.deleteTodoId == vm.todoList[i].id && vm.deleteTodoValue == vm.todoList[i].name)
                                vm.todoList.splice(i, 1);
                        }

                        document.getElementById(vm.deleteTodoId).checked = false;
                    }
                    
                    vm.deleteValue = vm.deleteTodoValue;
                    vm.activeOn = true;

                    vm.editTodoValue = '';
                    vm.deleteTodoId = 0;

                    // console.log(vm.todoList);

                    // console.log(vm.deleteTodoValue);
                    // console.log(vm.deleteTodoId);
                },

                completeButton: function ()
                {
                    let vm = this;

                    if(vm.deleteValue == '')
                    {
                        vm.sectionOne = false;
                        vm.sectionTwo = false;
                    }
                    else
                    {
                        vm.sectionOne = false;
                        vm.sectionTwo = true;
                    }


                    if(vm.activeOn == true)
                    {   
                        let data = [];

                        for(i=0; i<vm.todoList.length; i++)
                        {   
                            data[i] = {
                                id: vm.todoList[i].id,
                                name: vm.todoList[i].name
                            }
                        }

                        

                        // const options = {
                        //     url: 'api/todoGenerate',
                        //     method: 'GET',
                        //     headers: {
                        //         'X-Requested-With': 'XMLHttpRequest',
                        //         'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        //     },
                            
                        //     data: {
                        //         a: 10,
                        //         b: 20
                        //     }
                        //     };

                        //     axios(options)
                        //     .then(response => {
                        //         console.log(response);
                        //     });

                        console.log(data);

                        axios.get('api/todoGenerate?data=')
                        .then(function (response) {
                            console.log(response);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });

                      

                        vm.activeOn == false;

                    }
                    else 
                    {
                        vm.activeOn == false;
                        vm.allButton();
                    }
                    

                    // vm.sectionOne = false;
                    // vm.sectionTwo = true;
                }
            }
        });
    </script>

@stop
