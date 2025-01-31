<section id="body-left" class="system-block-body-left" data-min="<?php echo $_COOKIE["is_body_left_min"] ?? 0 ?>">
    <header>
        <img src="/image/logo.svg" alt="">
        <strong>{{ title }}</strong>
    </header>
    <button class="mobile" @click="body_left_show">
        <i class="fa-solid fa-chevron-left"></i>
        <span>收合列表</span>
    </button>
    <!--  -->
    <span>網站內容</span>
    <!--  -->
    <div>
        <p @click="tab_show">
            <i class="fa-solid fa-server"></i>
            <span>資料管理</span>
            <i class="fa-solid fa-chevron-right"></i>
        </p>
        <section data-row="2">
            <a href="/data/add" title="前往資料列表" data-selected="<?php echo $path === "/data/add" ? 1 : 0 ?>">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>新增資料</span>
            </a>
            <a href="/datas" title="前往資料列表" data-selected="<?php echo $path == "/datas/:uid/edit" || $path == "/datas" ? 1 : 0 ?>">
                <i class="fa-solid fa-table-list"></i>
                <span>資料列表</span>
            </a>
        </section>
    </div>
    <!--  -->
    <div>
        <p @click="tab_show">
            <i class="fa-solid fa-newspaper"></i>
            <span>文章管理</span>
            <i class="fa-solid fa-chevron-right"></i>
        </p>
        <section data-row="2">
            <a href="/article/add" title="前往資料列表" data-selected="<?php echo $path === "/article/add" ? 1 : 0 ?>">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>新增文章</span>
            </a>
            <a href="/articles" title="前往資料列表" data-selected="<?php echo $path == "/articles/:uid/edit" || $path == "/articles" ? 1 : 0 ?>">
                <i class="fa-solid fa-table-list"></i>
                <span>文章列表</span>
            </a>
        </section>
    </div>
    <!--  -->
    <div>
        <p @click="tab_show">
            <i class="fa-solid fa-folder-open"></i>
            <span>檔案管理</span>
            <i class="fa-solid fa-chevron-right"></i>
        </p>
        <section data-row="5">
            <a title="前往檔案管理" :data-selected="left.is_demo_folder">
                <i class="fa-solid fa-folder-open"></i>
                <span>[x] 檔案管理</span>
            </a>
            <a title="前往媒體展示" :data-selected="left.is_demo_media">
                <i class="fa-solid fa-photo-film"></i>
                <span>[x] 媒體展示</span>
            </a>
            <a title="前往 MD 檢視器" :data-selected="left.is_demo_md_viewer">
                <i class="fa-brands fa-markdown"></i>
                <span>[x] MD 檢視器</span>
            </a>
            <a title="前往文檔編輯" :data-selected="left.is_demo_text">
                <i class="fa-solid fa-file"></i>
                <span>[x] 文檔編輯</span>
            </a>
            <a title="前往文檔編輯" :data-selected="left.is_demo_json">
                <i class="fa-solid fa-layer-group"></i>
                <span>[x] JSON 編輯</span>
            </a>
        </section>
    </div>
    <!--  -->
    <span>會員內容</span>
    <!--  -->
    <div>
        <p @click="tab_show">
            <i class="fa-solid fa-user-shield"></i>
            <span>系統管理</span>
            <i class="fa-solid fa-chevron-right"></i>
        </p>
        <section data-row="4">
            <a href="" data-selected="">
                <i class="fa-solid fa-mail-bulk"></i>
                <span>[x] 信箱設定</span>
            </a>
            <a href="" data-selected="">
                <i class="fa-solid fa-unlock-alt"></i>
                <span>[x] 更改密碼</span>
            </a>
            <a href="" data-selected="">
                <i class="fa-solid fa-key"></i>
                <span>[x] 兩步驟驗證</span>
            </a>
            <button>
                <i class="fa-solid fa-language"></i>
                <span>[x] 中英切換</span>
            </button>
        </section>
    </div>
    <!--  -->
    <span>管理後台介紹</span>
    <!--  -->
    <div>
        <p @click="tab_show">
            <i class="fa-solid fa-code-branch"></i>
            <span>版本資訊</span>
            <i class="fa-solid fa-chevron-right"></i>
        </p>
        <section data-row="2">
            <a href="/document/readme" data-selected="<?php echo $path === "/document/readme" ? 1 : 0 ?>">
                <i class="fa-brands fa-readme"></i>
                <span>Readme</span>
            </a>
            <a href="/document/license" data-selected="<?php echo $path === "/document/license" ? 1 : 0 ?>">
                <i class="fa-solid fa-balance-scale"></i>
                <span>License</span>
            </a>
        </section>
    </div>
    <!--  -->
    <hr>
    <!--  -->
    <button class="desktop" @click="body_left_type">
        <i class="fa-solid fa-compress"></i>
        <i class="fa-solid fa-expand"></i>
    </button>
    <footer>
        <button @click="logout">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <span>登出</span>
        </button>
    </footer>
</section>