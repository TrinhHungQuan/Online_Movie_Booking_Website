<head>
    <link rel="stylesheet" href="css/styleslide.css" />
</head>
<body>
    <font>
      <marquee direction="left" style="background: rgb(121, 134, 238)">
         <b>WELCOME TO OUR CINEMA. THE BEST CHOICE FOR YOUR FREE TIME!</b>
      </marquee>
   </font>
    <div class="document-center">
      <!--This carousel-container only exists so we can do the 
      aspect ratio tricks in CSS-->
      <div class="carousel-container">
        <div class="carousel" id="carousel-1" auto-scroll="7000">
          <!--The uppermost screen will appear first. This is due to JavaScript-->
          <section class="carousel-screen">
            <img src="uploaded_img/post2.png" alt="Chicago Band" />
            
          </section>
          <section class="carousel-screen">
            <img src="uploaded_img/postbig2.jpg" alt="New York" />
            
          </section>
          <section class="carousel-screen">
            <img src="uploaded_img/postbig3.jpg" alt="Los Angeles" />
            
          </section>
          
          <!--These are not screens. They will always be on carousel-->
          <section class="circle-container">
            <!--These 'circles' need to match the number of carousel screens-->
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
          </section>
          <div class="left-arrow">
            <span class="chevron left"></span>
          </div>
          <div class="right-arrow">
            <span class="chevron right"></span>
          </div>
        </div>
      </div>
    </div>
    <script src="js/slide.js"></script>

  </body>
