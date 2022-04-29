
<header class="container flex sp_btw header">
      <nav class="flex header_navigation">
        <div class="header_logo">
          <img src="/img/logo.svg" alt="logo" class="header_logo_img">
          <p class="header_logo_p">Киноман</p>
        </div>
        
        <ul class="flex sp_btw header_navigation_list">
          <li><a href="{{route('catalog')}}">Фильмы</a></li>
          <li><a href="#">Сериалы</a></li>
          <li><a href="{{route('home')}}">Новинки</a></li>
        </ul>
      </nav>
      <div class="flex sp_btw header_blocks">
        
          <a href="#" class="flex header_blocks_search">
            <svg
              width="32"
              height="29"
              viewBox="0 0 50 50"
              xmlns="http://www.w3.org/2000/svg"
              class="header_blocks_img"
            >
              <path
                d="M48.8574 43.3301L37.168 31.6406C39.8262 27.6944 41.1377 22.7637 40.4356 17.5098C39.2383 8.57327 31.9141 1.30081 22.9688 0.168289C9.66895 -1.51462 -1.51464 9.66897 0.168369 22.9688C1.30118 31.918 8.57462 39.2481 17.5121 40.4395C22.766 41.1415 27.6977 39.8305 31.643 37.1719L43.3324 48.8613C44.8578 50.3867 47.3314 50.3867 48.8568 48.8613C50.3809 47.334 50.3809 44.8535 48.8574 43.3301ZM7.72462 20.3125C7.72462 13.4199 13.332 7.81253 20.2246 7.81253C27.1172 7.81253 32.7246 13.4199 32.7246 20.3125C32.7246 27.2051 27.1172 32.8125 20.2246 32.8125C13.332 32.8125 7.72462 27.2071 7.72462 20.3125Z"
              />
            </svg>
            Поиск
          </a>
        
        <div class="flex sp_btw header_blocks_login">
          <p class="flex header_blocks_search">
            <div onclick="myFunctionMenu()" class="flex dropdown header_blocks_dropdown">
              <svg width="32" height="29" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg" class="header_blocks_img">
                <path d="M25 0C11.1914 0 0 11.1914 0 25C0 38.8086 11.1914 50 25 50C38.8086 50 50 38.8086 50 25C50 11.1914 38.8086 0 25 0ZM25 12.5C28.8838 12.5 32.0312 15.6484 32.0312 19.5312C32.0312 23.4141 28.8867 26.5625 25 26.5625C21.1172 26.5625 17.9688 23.4141 17.9688 19.5312C17.9688 15.6484 21.1133 12.5 25 12.5ZM25 43.75C19.8311 43.75 15.1465 41.6475 11.748 38.2529C13.3301 34.1699 17.2363 31.25 21.875 31.25H28.125C32.7676 31.25 36.6738 34.168 38.252 38.2529C34.8535 41.6504 30.166 43.75 25 43.75Z"/>
              </svg>
              Войти
            </div>
            <div id="myDropdownMenu" class="flex header_blocks_authorization dropdown_drop_menu">
                <p class="header_blocks_authorization_p">
                  АВТОРИЗАЦИЯ
                </p>
                <form action="#" class="flex header_blocks_authorization_form">
                  <input type="text" class="header_blocks_authorization_input" 
                          placeholder="Введите логин"/>
                  <input type="password" name="password" id="password" 
                          class="header_blocks_authorization_input"
                          placeholder="Введите пароль" />
                </form>
                <a href="#" class="header_blocks_authorization_link">Нет учетной записи? <span class="grey_text">Зарегистрируйся</span></a>
              </div>
          </p>
        </div>
      </div>
    </header>
