# laravel-vocabulary

使用 PHP Laravel 來建立後端 API

搭配 Vue 3 前端：[vue-vocabulary](https://github.com/tk50486yui/vue-vocabulary.git)

後端 Slim 版本（舊）：[slim-vocabulary](https://github.com/tk50486yui/slim-vocabulary.git)

---
## PHP 7.2.12

---
## Laravel 7.30.6

---
## PostgreSQL 9.6.24

資料庫使用 PostgreSQL，表格可參照 [Database Tables](table/tables.sql)

---
## 目錄架構
```    
+ laravel-vocabulary
    │
    ├─ app                      // 主程式目錄
    │   ├─ Console
    │   ├─ Exceptions
    │   │   ├─ Custom           // 定義例外
    │   │   │   └─ Responses    // 定義訊息
    │   │   └─ Handler.php      // 例外集中處理
    │   ├─ Http
    │   │   ├─ Controllers      // 接收 routes 的 request，並將資料交由 Service 處理
    │   │   ├─ Middleware       // 中介層
    │   │   └─ Requests         // 驗證所有 request
    │   ├─ Models               // Eloquent Model
    │   ├─ Observers            // 執行 creating 及 updating
    │   ├─ Providers            // 只使用 Event 註冊 Observer
    │   ├─ Repositories         // 所有 SQL 及 Eloquent 操作
    │   ├─ Services             // 實際執行所有交易，並回傳給 Controller
    │   │    ├─ Outputs         // 資料欄位及格式設定
    │   │    └─ Processors      // Services 資料預處理
    │   └─ Validators           // 驗證器
    │       └─ ModelValidators  // Model 欄位驗證
    ├─ bootstrap
    ├─ config                   // app cors 設定
    ├─ database
    ├─ public
    ├─ resources
    ├─ routes                   // 路由設定，只使用 api.php
    ├─ storage
    └─ tests                    // 測試

```