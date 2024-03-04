<!DOCTYPE html>
<html lang="">
<head>
  <title>Student Record Management</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="shortcut icon" href="{{ asset('assets/favicon.ico') }}">

  <!-- plugin css -->
  <link rel="stylesheet" href="{{asset('assets/plugins/@mdi/font/css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.css')}}">
  <!-- end plugin css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


  <!-- common css -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
  <!-- end common css -->


</head>
<body data-base-url="{{url('/')}}">

  <div class="container-scroller" id="app">
{{--    @include('layout.header')--}}
    <div class="container-fluid page-body-wrapper">
      @include('layout.sidebar')

      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')
        </div>
      </div>
    </div>
  </div>




  <script src="{{asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="{{asset('js/index3.js')}}"></script>

  <script>
      let parentIndex = 0
      function SearchVideo() {
          closeForm3();
          const chatContainer = document.querySelector('.chat-container');
          const gridContainer = document.querySelector('.grid-container');
          const videoInput = document.getElementById('video');
          var vidPath = document.getElementById('video').value;
          var vidName = vidPath.split('\\').pop();
          const search_word = document.getElementById('message-video').value;

          const userMessage = document.createElement('div');
          userMessage.classList.add('chat-bubble', 'user-chat');
          userMessage.innerHTML = `<span class="message">${search_word}</span>`;
          chatContainer.appendChild(userMessage);

          if (videoInput.files.length > 0) {
              const vidFile = videoInput.files[0];
              const vidPath = URL.createObjectURL(vidFile); // Lấy đường dẫn đến file hình vid

              // Tạo chat bubble cho hình ảnh
              const videoBubble = document.createElement('div');
              videoBubble.classList.add('chat-bubble', 'user-chat');


              const vidElement = document.createElement('video');
              vidElement.style.width = '200px';
              vidElement.style.height = 'auto';
              vidElement.setAttribute('controls', ''); // Hiển thị controls
              const sourceElement = document.createElement('source');
              sourceElement.setAttribute('src', vidPath); // Đặt đường dẫn của video
              sourceElement.setAttribute('type', 'video/mp4'); // Đặt kiểu video
              vidElement.appendChild(sourceElement); // Thêm source vào video
              videoBubble.appendChild(vidElement);

              // Thêm chat bubble video vào khung chat
              chatContainer.appendChild(videoBubble);
          }


          // Ẩn grid-container
          gridContainer.classList.add('hidden');


          $.ajax({
              url: "http://localhost/SearchEngine/public/api/video_search",
              type: "GET",
              data: vidName,
              success: function (response){

                  console.log(parentIndex)
                  console.log(response)
                  // Create a system chat container
                  const systemChat = document.createElement('div');
                  systemChat.classList.add('chat-bubble', 'system-chat');

                  // Create a chat bubble container
                  const chatBubble = document.createElement('div');
                  chatBubble.classList.add('chat-bubble', 'profile-info');

                  // Create a result container
                  const resultContainer = document.createElement('div');
                  resultContainer.classList.add('result-container');

                  // Define titles and their corresponding ids
                  const titles = ["Website", "People", "Other"];
                  const ids = [1, 2, 3];

                  // Loop through the titles to create result items, titles, sub-item containers, and sub-items
                  titles.forEach((title, index) => {
                      // Create result item with unique id
                      const resultItem = document.createElement('div');
                      resultItem.classList.add('result-item');
                      resultItem.id = `result-item-${ids[index]}`;

                      // Create title element
                      const titleElement = document.createElement('div');
                      titleElement.classList.add('title2');
                      titleElement.id = `title-${ids[index]}`;
                      titleElement.innerHTML = `<b>${title}</b>`;

                      // Create sub-item container with unique id
                      const subItemContainer = document.createElement('div');
                      subItemContainer.classList.add('sub-item-container');
                      subItemContainer.id = `sub-item-container-${ids[index]}`;

                      if(title === 'Website') {
                          const subItem = document.createElement('div');
                          subItem.classList.add('sub-item');
                          subItem.id = `sub-item-${parentIndex + 1}`;
                          subItem.innerHTML = ''; // Sub-item content will be filled based on response
                          subItemContainer.appendChild(subItem);
                      }else {
                          // Loop to create sub-items with unique ids
                          for (let i = 0; i <= 1; i++) {
                              const subItem = document.createElement('div');
                              subItem.classList.add('sub-item');
                              subItem.id = `sub-item-${(index * 2) + i +parentIndex}`;
                              subItem.innerHTML = ''; // Sub-item content will be filled based on response
                              subItemContainer.appendChild(subItem);
                          }
                      }

                      // Append title to result item
                      resultItem.appendChild(titleElement);

                      // Append sub-item container to result item
                      resultItem.appendChild(subItemContainer);

                      // Append result item to result container
                      resultContainer.appendChild(resultItem);
                  });

                  // Append the result container to the chat bubble
                  chatBubble.appendChild(resultContainer);

                  // Append the chat bubble to the system chat
                  systemChat.appendChild(chatBubble);

                  // Append the system chat to the chat container
                  chatContainer.appendChild(systemChat);
                  var index = 1
                  let ARRY = [1,2]
                  //   Fill sub-items with response data
                  ARRY.forEach((title) => {
                      if (response[0]) {
                          const subItem_1 = document.getElementById(`sub-item-${parentIndex+1}`);
                          subItem_1.innerHTML = `<div  class="sub-item-content">
                                    ${response[0].link_video}
                                    <p style="font-size: 14px; text-align: justify">${response[0].videoDescription}</p>
                                 </div>`;



                          const peopleKey = `people_${index}`;
                          const peopleimgKey = `people_${index}_img`;
                          const descriptionPeopleKey = `descriptionPeople_${index}`;

                          const subItem = document.getElementById(`sub-item-${index+1+parentIndex}`);
                          subItem.innerHTML = `<div  class="sub-item-content">
                                    <img src="${response[0][peopleimgKey]}" class="related-image">
                                    <h3 style="font-size: 14px; text-align: left">${response[0][peopleKey]}</h3>
                                    <p style="font-size: 14px; text-align: left">${response[0][descriptionPeopleKey]}</p>
                                 </div>`;


                      }
                      index++
                  });


              },
              error: function (xhr) {
                  console.error(xhr.responseText);
              }
          })
          parentIndex+=5
      }

      function SearchAudio() {
          closeForm4();
          const chatContainer = document.querySelector('.chat-container');
          const gridContainer = document.querySelector('.grid-container');
          const audioInput = document.getElementById('audio');
          var audioPath = document.getElementById('audio').value;
          var audioName = audioPath.split('\\').pop();
          const search_word = document.getElementById('message-audio').value;

          const userMessage = document.createElement('div');
          userMessage.classList.add('chat-bubble', 'user-chat');
          userMessage.innerHTML = `<span class="message">${search_word}</span>`;
          chatContainer.appendChild(userMessage);

          if (audioInput.files.length > 0) {
              const audioFile = audioInput.files[0];
              const audioPath = URL.createObjectURL(audioFile); // Lấy đường dẫn đến file hình vid

              // Tạo chat bubble cho hình ảnh
              const audioBubble = document.createElement('div');
              audioBubble.classList.add('chat-bubble', 'user-chat');


              const audioElement = document.createElement('video');
              audioElement.style.width = '200px';
              audioElement.style.height = 'auto';
              audioElement.setAttribute('controls', ''); // Hiển thị controls
              const sourceElement = document.createElement('source');
              sourceElement.setAttribute('src', audioPath); // Đặt đường dẫn của video
              sourceElement.setAttribute('type', 'audio/mpeg'); // Đặt kiểu video
              audioElement.appendChild(sourceElement); // Thêm source vào video
              audioBubble.appendChild(audioElement);

              // Thêm chat bubble video vào khung chat
              chatContainer.appendChild(audioBubble);
          }


          // Ẩn grid-container
          gridContainer.classList.add('hidden');

          $.ajax({
              url: "http://localhost/SearchEngine/public/api/audio_search",
              type: "GET",
              data: audioName,
              success: function (response){
                  console.log(parentIndex)
                  console.log(response)
                  // Create a system chat container
                  const systemChat = document.createElement('div');
                  systemChat.classList.add('chat-bubble', 'system-chat');

                  // Create a chat bubble container
                  const chatBubble = document.createElement('div');
                  chatBubble.classList.add('chat-bubble', 'profile-info');

                  // Create a result container
                  const resultContainer = document.createElement('div');
                  resultContainer.classList.add('result-container');

                  // Define titles and their corresponding ids
                  const titles = ["Song", "Video", "Voice People"];
                  const ids = [1, 2, 3];

                  // Loop through the titles to create result items, titles, sub-item containers, and sub-items
                  titles.forEach((title, index) => {
                      // Create result item with unique id
                      const resultItem = document.createElement('div');
                      resultItem.classList.add('result-item');
                      resultItem.id = `result-item-${ids[index]}`;

                      // Create title element
                      const titleElement = document.createElement('div');
                      titleElement.classList.add('title2');
                      titleElement.id = `title-${ids[index]}`;
                      titleElement.innerHTML = `<b>${title}</b>`;

                      // Create sub-item container with unique id
                      const subItemContainer = document.createElement('div');
                      subItemContainer.classList.add('sub-item-container');
                      subItemContainer.id = `sub-item-container-${ids[index]}`;

                      if(title === 'Song') {
                          const subItem = document.createElement('div');
                          subItem.classList.add('sub-item');
                          subItem.id = `sub-item-${parentIndex+1}`;
                          subItem.innerHTML = ''; // Sub-item content will be filled based on response
                          subItemContainer.appendChild(subItem);
                      }else if(title === 'Video') {
                          const subItem = document.createElement('div');
                          subItem.classList.add('sub-item');
                          subItem.id = `sub-item-${parentIndex+2}`;
                          subItem.innerHTML = ''; // Sub-item content will be filled based on response
                          subItemContainer.appendChild(subItem);
                      }else {
                              // Loop to create sub-items with unique ids
                              for (let i = 0; i <= 1; i++) {
                              const subItem = document.createElement('div');
                              subItem.classList.add('sub-item');
                              subItem.id = `sub-item-${(index * 2) + i - 1 + parentIndex}`;
                              subItem.innerHTML = ''; // Sub-item content will be filled based on response
                              subItemContainer.appendChild(subItem);
                          }
                      }

                      // Append title to result item
                      resultItem.appendChild(titleElement);

                      // Append sub-item container to result item
                      resultItem.appendChild(subItemContainer);

                      // Append result item to result container
                      resultContainer.appendChild(resultItem);
                  });

                  // Append the result container to the chat bubble
                  chatBubble.appendChild(resultContainer);

                  // Append the chat bubble to the system chat
                  systemChat.appendChild(chatBubble);

                  // Append the system chat to the chat container
                  chatContainer.appendChild(systemChat);
                  var index = 1
                  let ARRY = [1,2,3]
                  //   Fill sub-items with response data
                  ARRY.forEach((title) => {
                      console.log(response[0])
                      if (response[0]) {
                          const subItem_1 = document.getElementById(`sub-item-${parentIndex+1}`);
                          subItem_1.innerHTML = `<div  class="sub-item-content">
                                    <h3 style="font-size: 14px; text-align: justify">${response[0].Song_name}</h3>
                                    <p style="font-size: 14px; text-align: justify">${response[0].songDescription}</p>
                                 </div>`;

                          const subItem_2 = document.getElementById(`sub-item-${parentIndex+2}`);
                          subItem_2.innerHTML = `<div  class="sub-item-content">

                                    <p style="font-size: 14px; text-align: justify">${response[0].videoDescription}</p>
                                 </div>`;

                          const peopleKey = `people_${index}`;
                          const peopleimgKey = `people_${index}_img`;
                          const descriptionPeopleKey = `descriptionPeople_${index}`;

                          const subItem = document.getElementById(`sub-item-${index+2+parentIndex}`);
                          subItem.innerHTML = `<div  class="sub-item-content">
                                    <img src="${response[0][peopleimgKey]}" class="related-image">
                                    <h3 style="font-size: 14px; text-align: left">${response[0][peopleKey]}</h3>
                                    <p style="font-size: 14px; text-align: left">${response[0][descriptionPeopleKey]}</p>
                                 </div>`;

                      }
                      index++
                  });

              },
              error: function (xhr) {
                  console.error(xhr.responseText);
              }
          })
          parentIndex+=5
      }


      {{--function searchImageAI() {--}}
      {{--    const chatContainer = document.querySelector('.chat-container');--}}
      {{--    const gridContainer = document.querySelector('.grid-container');--}}
      {{--    var search_word = document.getElementById('search_word').value;--}}
      {{--    console.log(search_word)--}}
      {{--    const userMessage = document.createElement('div');--}}
      {{--    // userMessage.classList.add('chat-bubble', 'user-chat');--}}
      {{--    // userMessage.innerHTML = `<span class="message">${search_word}</span>`;--}}
      {{--    // chatContainer.appendChild(userMessage);--}}
      {{--    gridContainer.classList.add('hidden');--}}
      {{--    $.ajax({--}}
      {{--        url: '{{route('get_image')}}',--}}
      {{--        type: "GET",--}}
      {{--        data: {data: search_word},--}}
      {{--        success: function (response){--}}
      {{--            var obj = JSON.parse(response)--}}
      {{--            console.log(obj)--}}
      {{--            console.log(obj.image)--}}
      {{--            const systemMessage = document.createElement('div');--}}
      {{--            systemMessage.classList.add('chat-bubble', 'system-chat');--}}
      {{--            systemMessage.innerHTML = `<img style="width: 100%; height: auto" src="data:image/jpeg;base64,${obj.image}">`;--}}
      {{--            chatContainer.appendChild(systemMessage)--}}



      {{--        },--}}
      {{--        error: function (xhr) {--}}
      {{--            console.error(xhr.responseText)--}}
      {{--        }--}}
      {{--    })--}}
      {{--}--}}
  </script>
</body>
</html>
