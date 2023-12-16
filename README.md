# laravel-vocabulary

使用 PHP Laravel 來建立後端 API，並搭配 Redis 緩存資料。

搭配 Vue 3 前端：[vue-vocabulary](https://github.com/tk50486yui/vue-vocabulary.git)

後端 Slim 版本（舊）：[slim-vocabulary](https://github.com/tk50486yui/slim-vocabulary.git)

---
### 系統簡介

為 [vue-vocabulary](https://github.com/tk50486yui/vue-vocabulary.git) 提供 API 資料存取接口。

[簡易 Demo](https://vue.yuex.site/vue-vocabulary/)

[單字 Words API Demo](https://api.yuex.site/public/api/words)

---
### 開發環境

PHP 7.2.12

Laravel 7.30.6

PostgreSQL 9.6.24 - 資料表及欄位可參照 [Database Tables](pgsql/tables.sql)

Redis - [Version](https://github.com/microsoftarchive/redis/releases/tag/win-3.0.504)

---
### Docker

``` 
docker-compose up -d
``` 

會建立 Laravel、PostgreSql 和 Redis 的 Service。

---
### 目錄架構
```    
+ laravel-vocabulary
    ├─ app
    │   ├─ Console
    │   ├─ Events               // Event
    │   ├─ Exceptions
    │   │   ├─ Custom           // Exception
    │   │   │   └─ Responses    // Exception Message
    │   │   └─ Handler.php      // Exception 集中處理
    │   ├─ Http
    │   │   ├─ Controllers      // 接收 Route 並呼叫 Service 處理
    │   │   ├─ Middleware       // Middleware
    │   │   └─ Requests         // 驗證所有 request
    │   ├─ Listeners            // Listener
    │   ├─ Models               // Eloquent Model
    │   ├─ Observers            // creating updating
    │   ├─ Providers            // 註冊 Event
    │   ├─ Repositories         // 所有 SQL 及 Eloquent 操作
    │   ├─ Services             // 實際執行所有交易
    │   │    ├─ Outputs         // 資料欄位及格式設定
    │   │    └─ Processors      // Services 資料預處理
    │   └─ Validators           // 驗證器
    │       └─ ModelValidators  // Model 欄位驗證
    ├─ bootstrap
    ├─ config                   // config
    ├─ database
    ├─ pgsql                    // .sql
    ├─ public
    ├─ resources
    ├─ routes                   // api.php
    ├─ storage
    └─ tests                    // test

```
---
### User Script

另有製作 Google 翻譯頁面瀏覽器插件，主要功能可將翻譯的詞彙儲存至自己的伺服器。

可查看 [UserScript](https://gist.github.com/tk50486yui/54cabdf110fbb4d3589a0fa9a8834bbe)