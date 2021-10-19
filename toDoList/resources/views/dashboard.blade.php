<head>
    <!-- <h1>    Demo on Laravel Notif SENDIGN   </h1> -->
    <script src="https://js.pusher.com/4.1/pusher.min.js">  </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        var pusher = new Pusher('{{env("MIX_PUSHER_APP_KEY")}}', {
            cluster: '{{env("PUSHER_APP_CLUSTER")}}',
            encrypted: true
        });

        var channel = pusher.subscribe('notify-channel');
        // var nitif =  document.getElementById('notif');
        channel.bind('App\\Events\\Notify', function(data){
            alert(data.message);
            // nitif.innerHtml = data.message;
        });
    </script>
    <script>
        const buttondel = document.getElementById('del');
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
            <div class="flex">
                <div class="flex-auto text-2xl mb-4">Tasks List</div>
                
                <div class="flex-auto text-right mt-2">
                    <a href="/task" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add new Task</a>
                </div>

            </div>
            <table class="w-full text-md rounded mb-4" id = "">
                <thead>
                <tr class="border-b">
                    <th class="text-left p-3 px-5">Task</th>
                    <th class="text-left p-3 px-5">Actions</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach(auth()->user()->tasks as $task)
                    <tr class="border-b hover:bg-orange-100" id = "{{$task->id}}">
                        <td class="p-3 px-5">
                            {{$task->description}}
                        </td>
                        <td class="p-3 px-5">
                            
                            <a href="/task/{{$task->id}}" name="edit" class="mr-3 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Edit</a>
                            <form action="/task/{{$task->id}}" class="inline-block" id = "form-del-{{$task->id}}" method="POST">
                                {{ csrf_field() }}
                                <button id = "del-{{$task->id}}" method="POST" type="submit" name="delete" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Delete</button>

                            </form>

                        </td>
                    </tr>
                    <!-- <script>
                        $(document).ready(function() {
                            var _token = $("input[name='_token']").val();
                            var form=$("#form-del-{{$task->id}}");
                            $(document).on('click', '#del-{{$task->id}}', async function (e) {
                                e.preventDefault();
                                if (navigator.onLine){
                                    $.ajax({
                                    type: 'delete',
                                    url:form.attr("action"),
                                    data:form.serialize(),
                                    success:function(data){
                                        alert(data);
                                    }
                                });
                                }
                                
                                await idxdbUpdt();
                                
                                if (!navigator.onLine){
                                    document.getElementById("form-del-{{$task->id}}").submit();
                                }
                                document.getElementById("{{$task->id}}").remove();
                                    });
                                });                      

                                async function idxdbUpdt(){
                                    
                                    //db change
                                    var db;
                                    var request = indexedDB.open("dashboardr", 1);
                                    // console.log(request)
                                    request.onerror = function(event) {
                                    console.log("Why didn't you allow my web app to use IndexedDB?!");
                                    };
                                    request.onsuccess = function(event) {
                                    db = request.result;
                                    // console.log(db)
                                    var request3 = db.transaction(["events"], "readwrite")
                                    .objectStore("events")
                                    var count = request3.count();
                                    count.onsuccess = function() {
                                        // console.log(count.result);
                                        var request2 = request3.get(count.result);
                                        request2.onsuccess = function(event) {
                                        // report the success of our request
                                            
                                            var myRecord = request2.result;
                                            var newItem = {event: [], id: count.result};
                                            myRecord.event.forEach(function(element) {
                                                    if (element.id != "{{$task->id}}"){
                                                        newItem.event.push({ id: element.id, description: element.description  });   
                                                    }
                                                })
                                            for (let i=1; i<=count.result; i++){
                                                request3.delete(i)
                                            }
                                            
                                            // request3.oncomplete = function() {
                                                    // delete the parent of the button, which is the list item, so it no longer is displayed
                                                    console.log(newItem)
                                                    var objectStoreRequest = request3.add(newItem);
                                                    objectStoreRequest.onsuccess = function(event) {
                                                                // report the success of our request
                                                    };
                                            //  };
                                            
                                        };

                                    };
                                    } 
                                }
                    </script>
                <script>
                                                             
                                                             var db1;
                                                             var request1 = indexedDB.open("dashboardr", 1);
                                                             
                                                             // console.log(request)
                                                             request1.onerror = function(event) {
                                                             console.log("Why didn't you allow my web app to use IndexedDB?!");
                                                             };
                                                             request1.onsuccess = function(event) {
                                                                 
                                                             db1 = request1.result;
                                                             var cnt;
                                                             // console.log(db)
                                                             var request4 = db1.transaction(["events"], "readwrite")
                                                             .objectStore("events")
                                                             var countRequest = request4.count();
                                                            countRequest.onsuccess = function() {
                                                                cnt = countRequest.result;
                                                            }
                                                             var request6 = request4.openCursor();
                                                             request6.onsuccess = function (e)
                                                             {
                                                                 var result = e.target.result;
                                                                 for (var i = 0; i < cnt-1; i++){
                                                                    result.continue();
                                                                }
                                                                 if(!!result == false) { return; }
                                                                 console.log(result.value["id"]+1)
                         
                                                                 var request3 = request4.get(result.value["id"]+1);
                                                                 request3.onsuccess = function(event) {
                                                                 // report the success of our request
                                                                     
                                                                     var myRecord1 = request3.result;
                                                                     var del = 1;
                                                                     myRecord1.event.forEach(function(element) {
                                                                             if (element.id == "{{$task->id}}"){
                                                                                 del = 0;  
                                                                             }
                                                                         })
                                                                     if (del == 1){
                                                                         document.getElementById("{{$task->id}}").remove();
                                                                     }
                         
                                                                     
                                                             };
                                                                 // Use result.value some how
                         
                                                                 // Comment out this line to process the first item only
                                                                 //result.continue();
                                                             };
                         
                                                             }
                                         </script>                     -->
                @endforeach

                </tbody>
            </table>
            
        </div>
    </div>
</div>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
            <div class="flex">
                <div class="flex-auto text-2xl mb-4">Send Notification</div>
                
                <div class="flex-auto text-right mt-2">
                   <form method="POST" action="/send">

                        <div class="form-group">
                            <textarea name="nitif" class="bg-gray-100 rounded border border-gray-400 leading-normal resize-none w-full h-20 py-2 px-3 font-medium placeholder-gray-700 focus:outline-none focus:bg-white"  placeholder='Enter Notification'></textarea>  
                            @if ($errors->has('nitif'))
                                <span class="text-danger">{{ $errors->first('nitif') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Send to All</button>
                        </div>
                        {{ csrf_field() }}
                </form>
                </div>

            </div>
   
        </div>
    </div>
</div>
</x-app-layout>