 <style>
 .chat-header{
	 gap:0em !important;
 }
 
 .chat-window{
	width: 430px;
	height: 100px;
	background: #fff;
	border: 1px solid #ddd;
	box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.3); /* offset-x, offset-y, blur, color */
 }

  /* Chatbot Styles */
.chatbot-button {
  position: fixed;
  top: 65px;
  right: 15px;
  background-color: rgba(0, 0, 0, 0.01); /* semi-transparent black */
  color: #fff;
  border: none;
  border-radius: 50%; /* circular button */
  width: 50px;
  height: 50px;
  padding: 0;
  font-size: 24px;
  cursor: pointer;
  display: flex;
  /* align-items: center;       vertically center icon */
  justify-content: center;  /* horizontally center icon */
  transition: all 0.3s ease;
  z-index: 10000;
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1); /* subtle shadow */
}

/* Optional: hover effect */
.chatbot-button:hover {
  height:50px;
  width:50px;
  background-color: rgba(0, 0, 0, 0.7); /* darker on hover */
  transform: scale(1.1);                /* slight zoom */
}  
  /* Chatbot iframe container */
  .chatbot-wrapper {
    position: fixed;
    bottom: 40px;
    right: 65px;
    width: 400px;
    height: 500px;
    background-color: white;
    border-radius: 12px;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
    z-index: 9999;
    overflow: hidden;
    display: none;
    transition: all 0.3s ease;
    border: 1px solid #e0e0e0;
  }
  
  .chatbot-wrapper iframe {
    width: 100%;
    height: 100%;
    border: none;
    border-radius: 12px;
  }
  
  /* Responsive Design */
  @media (max-width: 768px) {
    .chatbot-wrapper {
      width: 80px;
      height: 550px;
      right: 15px;
      bottom: 90px;
    }
    
    .chatbot-button {
      right: 15px;
      bottom: 20px;
    }
  }
  
  @media (max-width: 576px) {
    .chatbot-wrapper {
      width: calc(100% - 30px);
      right: 15px;
      height: 500px;
    }
  }
  
  
  
  
 /* name under image */ 
.chatbot-button{
    display: flex;
    flex-direction: column;
    align-items: center;
    background: transparent;
    border: none;
    cursor: pointer;
}

.chatbot-button img{
    height: 50px;
    width: 50px;
    border-radius: 50%;
}

.chatbot-button span{
    font-size: 10px;
    margin-top: 4px;
}

</style>

 
 
<!-- Chatbot Button -->
<button class="chatbot-button" id="chatbotToggle" style="border:none;background:transparent;">
    <img src="assets/nmc/images/RobotGIF.gif"
         alt="Nmc Smart Mitra"
         title="Nmc Smart Mitra"
         style="height:50px;width:50px;border-radius:50%;" />

    <div class="d-flex justify-content-around" style="font-size:10px; margin-top:4px; text-align:center;font-weight:bold;color:#FFF;background-color:#ff9547;padding:1px;">
       <div>Smart&nbsp;</div><div>Mitra</div>
    </div>
</button>

<!-- Chatbot Embed -->
<div class="chatbot-wrapper" id="chatbotWrapper">
  <iframe 
    src="https://nagpur-chat-buddy.vercel.app"
    allow="clipboard-read; clipboard-write">
  </iframe>
</div>


<script>
  // Chatbot functionality
  const toggleBtn = document.getElementById('chatbotToggle');
  const chatbotWrapper = document.getElementById('chatbotWrapper');
  
  toggleBtn.addEventListener('click', () => {
    const isVisible = chatbotWrapper.style.display === 'block';
    chatbotWrapper.style.display = isVisible ? 'none' : 'block';
  });
  
  // Close chatbot when clicking outside (optional)
  document.addEventListener('click', (event) => {
    const isClickInsideChatbot = chatbotWrapper.contains(event.target);
    const isClickOnToggle = toggleBtn.contains(event.target);
    
    if (!isClickInsideChatbot && !isClickOnToggle && chatbotWrapper.style.display === 'block') {
      chatbotWrapper.style.display = 'none';
    }
  });
</script><!--  chatbot end -->
