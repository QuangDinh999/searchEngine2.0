function openForm() {
    document.getElementById("myForm").style.display = "block";
    document.getElementById("overlay").style.display = "block";
}

function closeForm() {
    document.getElementById("myForm").style.display = "none";
    document.getElementById("overlay").style.display = "none";
}

function openForm2() {
    document.getElementById("myForm2").style.display = "block";
    document.getElementById("overlay").style.display = "block";
}

function closeForm2() {
    document.getElementById("myForm2").style.display = "none";
    document.getElementById("overlay").style.display = "none";
}

function openForm3() {
    document.getElementById("myForm3").style.display = "block";
    document.getElementById("overlay").style.display = "block";
}

function closeForm3() {
    document.getElementById("myForm3").style.display = "none";
    document.getElementById("overlay").style.display = "none";
}


function openForm4() {
    document.getElementById("myForm4").style.display = "block";
    document.getElementById("overlay").style.display = "block";
}

function closeForm4() {
    document.getElementById("myForm4").style.display = "none";
    document.getElementById("overlay").style.display = "none";
}
document.addEventListener('DOMContentLoaded', function () {
    const searchForm = document.querySelector('.search-form');
    const chatContainer = document.querySelector('.chat-container');
    const gridContainer = document.querySelector('.grid-container');

    searchForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const searchInput = searchForm.querySelector('input[type="text"]');
        const searchTerm = searchInput.value.trim(); // Loại bỏ khoảng trắng ở đầu và cuối chuỗi

        if (searchTerm !== '') { // Kiểm tra xem người dùng đã nhập từ khóa tìm kiếm hay chưa
            // Tạo tin nhắn của người dùng
            const userMessage = document.createElement('div');
            userMessage.classList.add('chat-bubble', 'user-chat');
            userMessage.innerHTML = `<span class="message">${searchTerm}</span>`;

            // Hiển thị tin nhắn của người dùng trong khung chat
            chatContainer.appendChild(userMessage);

            // Ẩn grid-container
            gridContainer.classList.add('hidden');

            // Xóa nội dung trong ô tìm kiếm sau khi đã xử lý
            searchInput.value = '';
        } else {
            alert('Please enter some word!'); // Thông báo nếu không có từ khóa nào được nhập
        }
    });

    $('#search_word').keypress(function (event) {
        if (event.keyCode === 13) {
            var search_word = document.getElementById('search_word').value.trim();
            console.log(search_word);
            if (search_word !== '') {
                if (search_word.includes('video')) {
                    var words = search_word.split(' ');
                    var keywordFound = false;
                    var keyword = "";

                    for (var i = 0; i < words.length; i++) {
                        if (keywordFound === true) {
                            keyword += words[i] + " ";
                        }
                        if (words[i] === "video") {
                            keywordFound = true;
                        }
                    }

                    var newKW = keyword.trim();
                    var apiKey = 'AIzaSyBELE6SWuSINH24B-g-kwDkc5LwaoXwexk'; // Thay YOUR_YOUTUBE_API_KEY bằng API key của bạn
                    var apiUrl = 'https://www.googleapis.com/youtube/v3/search?q=' + newKW + '&part=snippet&type=video&maxResults=1&key=' + apiKey;

                    $.ajax({
                        url: apiUrl,
                        type: "GET",
                        data: newKW,
                        success: function (response) {
                            // Lấy link video đầu tiên từ kết quả tìm kiếm
                            var videoId = response.items[0].id.videoId;
                            var videoLink = 'https://www.youtube.com/embed/' + videoId;

                            // Nhúng video vào trang web của bạn
                            var videoContainer = document.createElement('div');
                            videoContainer.classList.add('video-container');
                            videoContainer.innerHTML = '<iframe src="' + videoLink + '" allowfullscreen></iframe>';

                            const systemMessage = document.createElement('div');
                            systemMessage.classList.add('chat-bubble', 'system-chat');
                            systemMessage.innerHTML = '<span class="message">System response:</span>';
                            systemMessage.appendChild(videoContainer);

                            // Hiển thị hệ thống tin nhắn một cách từ từ
                            animateSystemMessage(systemMessage);

                            // Thêm hệ thống tin nhắn vào khung chat
                            chatContainer.appendChild(systemMessage);
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    $.ajax({
                        url: "http://localhost/SearchEngine/public/api/person",
                        type: "GET",
                        data: {data: search_word},
                        success: function (response) {
                            response.forEach(function (current) {
                                const personProfile = document.createElement('div');
                                personProfile.classList.add('chat-bubble', 'system-chat');

                                const profilePicture = document.createElement('img');
                                profilePicture.classList.add('chat-bubble', 'system-chat');
                                profilePicture.classList.add('profile-picture');
                                profilePicture.src = current.image;

                                const profileInfo = document.createElement('div');
                                profileInfo.classList.add('chat-bubble', 'system-chat');
                                profileInfo.classList.add('profile-info');


                                const profileDetails = `
                                    Name: ${current.name}
                                    Gender: ${current.gender}
                                    Age: ${current.age}
                                    Passport: ${current.passport}
                                    Phone: ${current.phone}
                                    Email: ${current.email}
                                    Address: ${current.address}
                                    Biography: ${current.Biography}
                                `;

                                profileInfo.innerHTML = profileDetails;

                                personProfile.appendChild(profilePicture);
                                personProfile.appendChild(profileInfo);

                                // Hiển thị hồ sơ của cá nhân một cách từ từ
                                animateProfile(personProfile);

                                // Thêm hồ sơ cá nhân vào khung chat
                                chatContainer.appendChild(personProfile);
                            });
                        },
                        error: function (xhr) {
                            // Xử lý lỗi nếu có
                            console.error(xhr.responseText);
                        }
                    });
                }
            }
        }
    });



    // Hàm thực hiện hiệu ứng animate từ trái sang phải cho hệ thống tin nhắn
    function animateSystemMessage(messageElement) {
        const messageText = messageElement.querySelector('.message');
        const messageTextContent = messageText.textContent;
        messageText.textContent = '';

        for (let i = 0; i < messageTextContent.length; i++) {
            setTimeout(function () {
                messageText.textContent += messageTextContent[i];
            }, 100 * i);
        }
    }

    // Hàm thực hiện hiệu ứng animate từ trái sang phải cho hồ sơ cá nhân
    function animateProfile(profileElement) {
        const profileInfo = profileElement.querySelector('.profile-info');
        const profileDetails = profileInfo.textContent; // Sử dụng textContent để lấy nội dung văn bản
        profileInfo.innerHTML = ''; // Xóa nội dung hiện tại

        const detailsArray = profileDetails.split('\n'); // Chia chuỗi thành mảng các mục

        const delayPerCharacter = 100; // Thời gian trễ cho mỗi ký tự
        const delayPerLine = 1000; // Thời gian trễ cho mỗi dòng

        detailsArray.forEach((detail, index) => {
            setTimeout(function () {
                const detailParagraph = document.createElement('p'); // Tạo một đoạn văn bản mới cho mỗi mục
                profileInfo.appendChild(detailParagraph); // Thêm đoạn văn bản vào profileInfo

                // Thêm hiệu ứng in từ từ từ trái sang phải
                animateText(detail, detailParagraph, delayPerCharacter);
            }, delayPerLine * index);
        });
    }

    function animateText(text, element) {
        const totalCharacters = text.length;
        const totalTimeInMilliseconds = 1500; // Tổng thời gian trong 1.5 giây
        const delay = totalTimeInMilliseconds / totalCharacters;

        for (let i = 0; i < text.length; i++) {
            setTimeout(function () {
                element.textContent += text[i]; // Thêm từng ký tự vào đoạn văn bản
            }, delay * i);
        }
    }
});

function SearchImage() {
    closeForm2();
    const chatContainer = document.querySelector('.chat-container');
    const gridContainer = document.querySelector('.grid-container');
    const imageInput = document.getElementById('image');
    var imgPath = document.getElementById('image').value;
    var imgName = imgPath.split('\\').pop();
    const search_word = document.getElementById('message-img').value;



    const userMessage = document.createElement('div');
    userMessage.classList.add('chat-bubble', 'user-chat');
    userMessage.innerHTML = `<span class="message">${search_word}</span>`;

    // Kiểm tra xem người dùng đã chọn hình ảnh chưa
    if (imageInput.files.length > 0) {
        const imgFile = imageInput.files[0];
        const imgPath = URL.createObjectURL(imgFile); // Lấy đường dẫn đến file hình ảnh

        // Tạo chat bubble cho hình ảnh
        const imageBubble = document.createElement('div');
        imageBubble.classList.add('chat-bubble', 'user-chat');

        // Thêm hình ảnh vào chat bubble
        const imgElement = document.createElement('img');
        imgElement.style.width = '200px';
        imgElement.style.height = 'auto';
        imgElement.src = imgPath; // Đặt đường dẫn của hình ảnh
        imageBubble.appendChild(imgElement);

        // Hiển thị chat bubble hình ảnh trước tin nhắn của người dùng
        chatContainer.insertBefore(imageBubble, chatContainer.firstChild);
    }
    // Hiển thị tin nhắn của người dùng trong khung chat
    chatContainer.appendChild(userMessage);

    // Ẩn grid-container
    gridContainer.classList.add('hidden');



    $.ajax({
        url: "http://localhost/SearchEngine/public/api/image_search",
        type: "GET",
        data: imgName,
        success: function (response){
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
            const titles = ["Website", "Movie", "People"];
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
                titleElement.innerHTML = title;

                // Create sub-item container with unique id
                const subItemContainer = document.createElement('div');
                subItemContainer.classList.add('sub-item-container');
                subItemContainer.id = `sub-item-container-${ids[index]}`;

                // Loop to create sub-items with unique ids
                for (let i = 1; i <= 2; i++) {
                    const subItem = document.createElement('div');
                    subItem.classList.add('sub-item');
                    subItem.id = `sub-item-${(index * 2) + i}`;
                    subItem.innerHTML = ''; // Sub-item content will be filled based on response
                    subItemContainer.appendChild(subItem);
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
            var index = 0
            let ARRY = [1,2,3,4,5,6]
            //   Fill sub-items with response data
            ARRY.forEach((title) => {
                console.log(index)
                console.log(response)
                if (response[0]) {
                    console.log(response)
                    const imgNameKey = `imgNameRelate${index + 1}`;
                    const descriptionKey = `description${index + 1}`;
                    // index++
                    const subItem = document.getElementById(`sub-item-${index+1}`);
                    subItem.innerHTML = `<div  class="sub-item-content">
                                    <img src="${response[0][imgNameKey]}" class="related-image">
                                    <p style="font-size: 14px">${response[0][descriptionKey]}</p>
                                 </div>`;

                }
                index++
                console.log(index)
            });
        },
        error: function (xhr) {
            console.error(xhr.responseText);
        }
    })
}





function displayDemoMedia(event) {
    const file = event.target.files[0];
    console.log(file)
    const fileType = file.type.split('/')[0]; // Lấy loại file
    console.log(fileType)

    if (fileType === 'image') {
        const img = document.getElementById('demo-image');
        img.style.display = 'block';
        img.src = URL.createObjectURL(file);
    } else if (fileType === 'video') {
        const video = document.getElementById('demo-video');
        console.log(video)
        video.style.display = 'block';
        video.src = URL.createObjectURL(file);
    }else if (fileType === 'audio') {
        const audio = document.getElementById('demo-audio');
        audio.style.display = 'block';
        console.log(audio)
        const source = document.createElement('source');
        source.src = URL.createObjectURL(file);
        source.type = file.type;

        audio.appendChild(source);
        audio.load();
    }
}
function displaySelectedImage(event) {
    var selectedImage = document.getElementById('selected-image');
    var input = event.target;

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            selectedImage.src = e.target.result;
            selectedImage.style.display = 'block'; // Hiển thị hình ảnh được chọn
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function removePicture() {
    var selectedImage = document.getElementById('selected-image');
    selectedImage.src = '#'; // Đặt lại đường dẫn hình ảnh
    selectedImage.style.display = 'none'; // Ẩn hình ảnh
}

function redirectToWelcome() {
    window.location.href = "http://localhost/SearchEngine/public"; // Chuyển hướng về trang chính
}

function redirectToTopic(topicId) {
    window.location.href = "http://localhost/SearchEngine/public/search/" + topicId;
}



function closeUploadOptions() {
    var uploadOptions = document.getElementById("uploadOptions");
    uploadOptions.style.display = "none";
}

function toggleUploadOptions() {
    var uploadOptions = document.getElementById("uploadOptions");
    if (uploadOptions.style.display === "none") {
        uploadOptions.style.display = "block";
    } else {
        uploadOptions.style.display = "none";
    }
}

function displayLoading() {
    var pinButton = document.getElementById("pinButton");
    pinButton.innerHTML = '<i class="mdi mdi-loading mdi-spin"></i>'; // Display loading icon
    setTimeout(function () {
        pinButton.innerHTML = '<i class="mdi mdi-check"></i>'; // Display checkmark icon after 1.5 seconds
    }, 1500);
}

function displaySelectedMediaInfo(file) {
    var pinButton = document.getElementById("pinButton");
    pinButton.innerHTML = '<i class="mdi mdi-check-circle-outline"></i>'; // Display checkmark icon
    pinButton.title = file.name; // Set tooltip to show file name
}

function uploadVideo() {
    var input = document.createElement('input');
    input.type = 'file';
    input.accept = 'video/*';
    input.onchange = function (event) {
        var file = event.target.files[0];
        if (file) {
            closeUploadOptions(); // Close upload options after selecting a file
            displayLoading(); // Display loading icon
            // Simulate uploading process
            setTimeout(function () {
                displaySelectedMediaInfo(file); // Display selected media info after 2 seconds
            }, 2000);
        }
    };
    input.click();
}

function uploadImage() {
    var input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*';
    input.onchange = function (event) {
        var file = event.target.files[0];
        if (file) {
            closeUploadOptions(); // Close upload options after selecting a file
            displayLoading(); // Display loading icon
            // Simulate uploading process
            setTimeout(function () {
                displaySelectedMediaInfo(file); // Display selected media info after 2 seconds
            }, 2000);
        }
    };
    input.click();
}

function uploadAudio() {
    var input = document.createElement('input');
    input.type = 'file';
    input.accept = 'audio/*';
    input.onchange = function (event) {
        var file = event.target.files[0];
        if (file) {
            closeUploadOptions(); // Close upload options after selecting a file
            displayLoading(); // Display loading icon
            // Simulate uploading process
            setTimeout(function () {
                displaySelectedMediaInfo(file); // Display selected media info after 2 seconds
            }, 2000);
        }
    };
    input.click();
}
