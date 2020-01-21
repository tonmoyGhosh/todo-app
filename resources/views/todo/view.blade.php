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
            
            <input type="text" class="form-control" placeholder="Add Todo List" v-model="todoValue" v-on:keyup.enter="insertList">

            <ul class="list-group" v-if="todoList.length">
                
                <li class="list-group-item" v-for="(record, index) in todoList">

                    <div class="checkbox" v-if="valueMatch != index">
                        <input type="checkbox" id="checkbox" class="checkbox checkbox-circle"/>
                        <label v-on:click="editForm(index, record)">
                            @{{ record }}
                        </label>
                    </div>

                    <div class="checkbox" v-if="updateSection">
                        <input type="text" class="form-control" v-model="editValue" v-on:keyup.enter="updateList(record)" v-if="valueMatch == index"/>
                    </div>
                
                </li>

                <li class="list-group-item">
                    <div class="checkbox">
                        <a href="#">All</a>
                        <a href="#">Active</a>
                        <a href="#">Completed</a>
                    </div>
                </li>
            </ul>

        </div>
    
    </div>
    
@stop

@section('script')

    <script src="https://unpkg.com/vue@2.6.11/dist/vue.min.js"></script>

    <script>
        new Vue({
            el: '#app',
            data: {
                todoValue: '',
                todoList: [],
                listSection: true,
                updateSection: false,
                editValue: '',
                valueMatch: -1,
            },
            methods: {
                insertList: function () {

                    let lengthArray = this.todoList.length;
                    
                    if(lengthArray == 0)
                        this.todoList[0] = this.todoValue;
                    else this.todoList[0+lengthArray] = this.todoValue;
                    
                    this.todoValue = '';
                },

                // updateList: function (param) {

                //     this.editActive = false;
                //     for(i=0; i<this.todoList.length; i++)
                //     {
                //         if(this.todoList[i] == param)
                //         {      
                //             this.todoList[i] = param;
                //             //ue.set(this.todoList, i, param);
                //         }
                //     }

                //     console.log(this.todoList);
                    
                // },

                editForm: function (index, value) {
                    this.listSection = false;
                    this.updateSection = true;
                    this.valueMatch = index;
                    this.editValue = value;
                }
            }
        });
    </script>

@stop
