# Under Flat

WordPressの標準的なテーマを作ったばい！  
「Under Flat」とは、**Underscores**と**Bootstrap**と**Flat UI**を合わせたやつ。  
早い話、GoogleさんみたいなUIになるとばい！

### Underscores
<http://underscores.me/>

WordPressの標準的なテーマ。  
「**Theme Name**」にテーマ名を入れて、「**GENERATE**」ボタンを押すだけ。  
簡単にテーマの基礎ができあがり！  

### Bootstrap
<http://getbootstrap.com/>

皆さんご存知、レスポンシブデザインに対応したCSSフレームワーク。  
PCとスマホの両方のデザインを作るのは面倒くさかけん、これが一番やね。  
バージョンは3.3.7を使用。  

### Flat UI
<http://designmodo.github.io/Flat-UI/>

Bootstrapをフラットデザインに変えてくれるCSSフレームワーク。  
書き方はBootstrapとほぼ同じやけん、勉強しなおさんでもよかと。  
バージョンは2.3.0を使用。    

## Underscoresから修正した内容

まず、CSSとJSを読み込ませるために「**functions.php**」を変更したと。  
直接ファイルは入れずに、**CDN**を使っとるけん。  
あ、ついでに**Font Awesome**も入れてます。  

### functions.php
    function flat_strap_scripts() {
        ・・・
        wp_enqueue_style( 'under-flat-roboto', '//fonts.googleapis.com/css?family=Roboto:300,400,500,700' );
        wp_enqueue_style( 'under-flat-icons', '//fonts.googleapis.com/icon?family=flat+Icons' );
        wp_enqueue_style( 'under-flat-font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
        wp_enqueue_style( 'under-flat-bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' );
        wp_enqueue_style( 'under-flat-design', '//cdnjs.cloudflare.com/ajax/libs/flat-ui/2.3.0/css/flat-ui.min.css' );
        wp_enqueue_style( 'under-flat-style', get_stylesheet_uri() );
        ・・・
        wp_enqueue_script( 'under-flat-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20170901', true );
        wp_enqueue_script( 'under-flat-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20170901', true );
        wp_enqueue_script( 'under-flat-jquery', '//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js', array(), '20170901', true );
        wp_enqueue_script( 'under-flat-video', '//cdnjs.cloudflare.com/ajax/libs/flat-ui/2.3.0/js/vendor/video.js', array(), '20170901', true );
        wp_enqueue_script( 'under-flat-design', '//cdnjs.cloudflare.com/ajax/libs/flat-ui/2.3.0/js/flat-ui.min.js', array(), '20170901', true );
        ・・・
    }

後は、Bootstrapの書き方の通り「**header.php**」ナビを追加したり、検索フォームのレイアウトを変えるために「**searchform.php**」を追加しとーけんね。（詳細はソースを見てね！）  
んでね、当然これだけじゃグリッドレイアウトにならんけん、サイドバー（ウィジェット）やメインコンテンツのレイアウトが崩れるったい。 
あんま好きじゃなかけど、できるだけUnderscoresのベースを変えたくなかけん、「**footer.php**」で後からjQueryでclassば差し込んどーと。  
サイドバー（sidebar.php）は「col-md-4」、メインコンテンツ（index.php他）は「col-md-8」を入れとるよ。  
比率は好きなように変えてんしゃい！  
他のやり方があったら教えてね。  

### footer.php
    <script type="text/javascript">
    $(document).ready(function() {
        // Content
        $('.site-content').addClass('container');
        $('.site-info').addClass('container');
        $('.content-area').addClass('col-md-8');
    	// Widget
        $('.widget-area').addClass('col-md-4');
        $('.widget > ul').addClass('list-group');
        $('.widget > ul > li').addClass('list-group-item');
        // Calendar
        $('#calendar_wrap').addClass('panel-body');
        $('#wp-calendar').addClass('table');
        // Text
        $('.textwidget').addClass('panel-body');
        // Tag Cloud
        $('.tagcloud').addClass('panel-body');
        // Form
        $('select,textarea,input:not([type=button],[type=submit])').addClass('form-control');
        $('[type=button],[type=submit]').addClass('btn btn-default');
        // Add to ...
    });
    </script>

## テーマオプションの追加

これだけじゃ面白くなかろ？  
そこで、このテンプレートの目玉！  
6パターンの色を変更できる「テーマオプション」機能を追加しました！  

管理画面の**「外観」＞「テーマオプション」**として追加したばい！  
設定画面は「**admin-option.php**」ていうファイル追加したと。  
ソースはtableタグでベタ書きしとーけん、あんまツッコまんでね...。  

んで、管理画面の設定と値の保存は「functions.php」に書いとるよ。  

### functions.php
    function under_flat_navswatch() {
        add_option('color');
        add_action('admin_menu', 'option_menu_create');
        function option_menu_create() {
            add_theme_page(esc_attr__( 'Theme Options' ), esc_attr__( 'Theme Options' ), 'edit_themes', basename(__FILE__), 'option_page_create');
        }
        function option_page_create() {
            $saved = under_flat_save_option();
            require TEMPLATEPATH.'/admin-option.php';
        }
    }
    function under_flat_save_option() {
        if (empty($_REQUEST['color'])) return;
        $save = update_option('color', $_REQUEST['color']);
        return $save;
    }
    add_action('init', 'under_flat_navswatch');

実際に読み込んでいるところは、**functions.php**の**under_flat_widgets_init()**関数の中と**header.php**に追加したけん。  

### functions.php
    function under_flat_widgets_init() {
        register_sidebar( array(
            ・・・
            'before_widget' => '<section id="%1$s" class="panel panel-' . get_option( 'color' ) . ' widget %2$s">',
            ・・・
        ) );
    }
    
### header.php
	<nav class="navbar navbar-fixed-top navbar-<?php echo get_option( 'color' ); ?>">

説明はここまで。  
home.phpとかはあえて作らんかった。  
そんなもん固定ページでなんとかなろーもん？  
まぁ、色々言いたいことあるやろーけど、ベースのテンプレートを作るってことで、これくらいにしとこ。  
