define({ "api": [  {    "type": "POST",    "url": "register",    "title": "注册",    "sampleRequest": [      {        "url": "https://echoyes.com/api/v1/register"      }    ],    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "mobile",            "description": "<p>手机号(必填)</p>"          },          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "code",            "description": "<p>验证码(必填)</p>"          },          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "password",            "description": "<p>密码(必填)</p>"          },          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "visitor_id",            "description": "<p>邀请人id(选填填)</p>"          }        ]      }    },    "permission": [      {        "name": "无"      }    ],    "name": "register",    "group": "A_Register",    "version": "1.0.0",    "description": "<p>api   注册接口</p>",    "success": {      "examples": [        {          "title": "Success-Response:",          "content": "HTTP/1.1 200 OK\n{\n     \"status\":\"200\",\n     \"msg\":\"注册成功\",\n     \"data\":[]\n}",          "type": "json"        }      ]    },    "error": {      "examples": [        {          "title": "Error-Response:",          "content": "HTTP/1.1 422 Not Found  422错误提示,请使用ajax异常扑获取\n {\n     \"message\": \"The given data was invalid.\",\n         \"errors\": {\n              \"type\": [\n                  \"type 不能为空。\"\n              ]\n          }\n       }",          "type": "json"        },        {          "title": "Error-Response:",          "content": "{\n    \"status\":\"400\",\n    \"msg\":\"错误提示\",\n    \"data\":[]\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/RegisterController.php",    "groupTitle": "A_Register"  },  {    "type": "POST",    "url": "login",    "title": "登录",    "sampleRequest": [      {        "url": "https://echoyes.com/api/v1/login"      }    ],    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "wx_oauth",            "description": "<p>微信登录唯一凭证(选填)</p>"          },          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "mobile",            "description": "<p>手机号(wx_oauth不存在时必填)</p>"          },          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "password",            "description": "<p>密码(wx_oauth不存在时必填)</p>"          }        ]      }    },    "permission": [      {        "name": "无"      }    ],    "name": "login",    "group": "B_Login",    "version": "1.0.0",    "description": "<p>api   登录接口</p>",    "success": {      "examples": [        {          "title": "Success-Response:",          "content": "HTTP/1.1 200 OK\n{\n     \"status\":\"200\",\n     \"msg\":\"登录成功\",\n     \"data\":{\n         \"token\":\"token\",\n         \"refresh_token\":\"refresh_token\",\n         \"user\":{\n             \"id\":\"id\",\n             \"mobile\":\"手机号\",\n             \"avatar\":\"头像\"\n         },\n     }\n}",          "type": "json"        }      ]    },    "error": {      "examples": [        {          "title": "Error-Response:",          "content": "HTTP/1.1 422 Not Found  422错误提示,请使用ajax异常扑获取\n {\n     \"message\": \"The given data was invalid.\",\n         \"errors\": {\n              \"type\": [\n                  \"type 不能为空。\"\n              ]\n          }\n       }",          "type": "json"        },        {          "title": "Error-Response:",          "content": "{\n    \"status\":\"400\",\n    \"msg\":\"错误提示\",\n    \"data\":[]\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/LoginController.php",    "groupTitle": "B_Login"  },  {    "type": "POST",    "url": "bind",    "title": "绑定手机号",    "sampleRequest": [      {        "url": "https://echoyes.com/api/v1/bind"      }    ],    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "wx_oauth",            "description": "<p>微信登录唯一凭证(必填)</p>"          },          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "mobile",            "description": "<p>手机号(必填)</p>"          },          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "code",            "description": "<p>密码(必填)</p>"          },          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "avatar",            "description": "<p>头像(必填)</p>"          }        ]      }    },    "permission": [      {        "name": "无"      }    ],    "name": "bind",    "group": "B_bind",    "version": "1.0.0",    "description": "<p>api   绑定手机号</p>",    "success": {      "examples": [        {          "title": "Success-Response:",          "content": "HTTP/1.1 200 OK\n{\n     \"status\":\"200\",\n     \"msg\":\"绑定成功\",\n     \"data\":{\n         \"token\":\"token\",\n         \"refresh_token\":\"refresh_token\",\n         \"user\":{\n             \"id\":\"id\",\n             \"mobile\":\"手机号\",\n             \"avatar\":\"头像\"\n         },\n     }\n}",          "type": "json"        }      ]    },    "error": {      "examples": [        {          "title": "Error-Response:",          "content": "HTTP/1.1 422 Not Found  422错误提示,请使用ajax异常扑获取\n {\n     \"message\": \"The given data was invalid.\",\n         \"errors\": {\n              \"type\": [\n                  \"type 不能为空。\"\n              ]\n          }\n       }",          "type": "json"        },        {          "title": "Error-Response:",          "content": "{\n    \"status\":\"400\",\n    \"msg\":\"绑定成功\",\n    \"data\":[]\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/BindController.php",    "groupTitle": "B_bind"  },  {    "type": "POST",    "url": "captcha/send",    "title": "发送验证码",    "sampleRequest": [      {        "url": "https://echoyes.com/api/v1/captcha/send"      }    ],    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "mobile",            "description": "<p>手机号(必填)</p>"          },          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "type",            "description": "<p>密码(类型【注册:'10000'】 【修改密码:'10001'】 【绑定微信:'10002'】 )</p>"          }        ]      }    },    "permission": [      {        "name": "无"      }    ],    "name": "captcha_send",    "group": "C_Captcha",    "version": "1.0.0",    "description": "<p>api   发送验证码接口</p>",    "success": {      "examples": [        {          "title": "Success-Response:",          "content": "HTTP/1.1 200 OK\n{\n     \"status\":\"200\",\n     \"msg\":\"发送成功\",\n     \"data\":[]\n}",          "type": "json"        }      ]    },    "error": {      "examples": [        {          "title": "Error-Response:",          "content": "HTTP/1.1 422 Not Found  422错误提示,请使用ajax异常扑获取\n {\n     \"message\": \"The given data was invalid.\",\n         \"errors\": {\n              \"type\": [\n                  \"type 不能为空。\"\n              ]\n          }\n       }",          "type": "json"        },        {          "title": "Error-Response:",          "content": "{\n    \"status\":\"400\",\n    \"msg\":\"错误提示\",\n    \"data\":[]\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/CaptchaController.php",    "groupTitle": "C_Captcha"  },  {    "type": "POST",    "url": "home",    "title": "首页",    "sampleRequest": [      {        "url": "https://echoyes.com/api/v1/home"      }    ],    "header": {      "fields": {        "Header": [          {            "group": "Header",            "type": "String",            "optional": false,            "field": "authorization",            "description": "<p>Authorization value.</p>"          }        ]      }    },    "permission": [      {        "name": "无"      }    ],    "name": "home",    "group": "D_home",    "version": "1.0.0",    "description": "<p>api   首页接口</p>",    "success": {      "examples": [        {          "title": "Success-Response:",          "content": "HTTP/1.1 200 OK\n{\n     \"status\":\"200\",\n     \"msg\":\"获取成功\",\n     \"data\":[\n         \"banners\":[\n             {\n                 \"id\":\"id\",\n                 \"img_url\":\"图片url\",\n             }\n         ],\n         \"home\":{\n             \"id\":\"id\"\n             \"title\":\"标题\",\n             \"content\":\"内容\"\n         }\n     ]\n}",          "type": "json"        }      ]    },    "error": {      "examples": [        {          "title": "Error-Response:",          "content": "HTTP/1.1 422 Not Found  422错误提示,请使用ajax异常扑获取\n {\n     \"message\": \"The given data was invalid.\",\n         \"errors\": {\n              \"type\": [\n                  \"type 不能为空。\"\n              ]\n          }\n       }",          "type": "json"        },        {          "title": "Error-Response:",          "content": "{\n    \"status\":\"400\",\n    \"msg\":\"错误提示\",\n    \"data\":[]\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/HomeController.php",    "groupTitle": "D_home"  },  {    "type": "POST",    "url": "good",    "title": "商品",    "sampleRequest": [      {        "url": "https://echoyes.com/api/v1/good"      }    ],    "header": {      "fields": {        "Header": [          {            "group": "Header",            "type": "String",            "optional": false,            "field": "authorization",            "description": "<p>Authorization value.</p>"          }        ]      }    },    "permission": [      {        "name": "无"      }    ],    "name": "home",    "group": "E_Good",    "version": "1.0.0",    "description": "<p>api   商品接口</p>",    "success": {      "examples": [        {          "title": "Success-Response:",          "content": "HTTP/1.1 200 OK\n{\n     \"status\":\"200\",\n     \"msg\":\"获取成功\",\n     \"data\":[\n         \"good\":[\n             \"id\":\"id\",\n             \"title\":\"商品标题\",\n             \"price\":\"商品价格\",\n             \"sales_volume\":\"销量\",\n             \"describe\":\"描述\",\n             \"stock\":\"库存\",\n             \"good_imgs\":[\n                 {\n                     \"id\":\"商品图片id\",\n                     \"img_url\":\"图片链接\",\n                 }\n             ],\n         ],\n     ]\n}",          "type": "json"        }      ]    },    "error": {      "examples": [        {          "title": "Error-Response:",          "content": "HTTP/1.1 422 Not Found  422错误提示,请使用ajax异常扑获取\n {\n     \"message\": \"The given data was invalid.\",\n         \"errors\": {\n              \"type\": [\n                  \"type 不能为空。\"\n              ]\n          }\n       }",          "type": "json"        },        {          "title": "Error-Response:",          "content": "{\n    \"status\":\"400\",\n    \"msg\":\"错误提示\",\n    \"data\":[]\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/GoodController.php",    "groupTitle": "E_Good"  },  {    "type": "POST",    "url": "address",    "title": "地址列表",    "sampleRequest": [      {        "url": "https://echoyes.com/api/v1/address"      }    ],    "header": {      "fields": {        "Header": [          {            "group": "Header",            "type": "String",            "optional": false,            "field": "authorization",            "description": "<p>Authorization value.</p>"          }        ]      }    },    "permission": [      {        "name": "无"      }    ],    "name": "address",    "group": "F_Address",    "version": "1.0.0",    "description": "<p>api   地址接口</p>",    "success": {      "examples": [        {          "title": "Success-Response:",          "content": "HTTP/1.1 200 OK\n{\n     \"status\":\"200\",\n     \"msg\":\"获取成功\",\n     \"data\":[\n         \"address\":[\n             {\n                 \"id\":\"id\",\n                 \"to_name\":\"收件人\",\n                 \"mobile\":\"手机号\",\n                 \"province\":\"省\",\n                 \"city\":\"市\",\n                 \"area\":\"区\",\n                 \"detail\":\"详细地址\",\n                 \"postcode\":\"邮政编码\"\n             }\n         ],\n     ]\n}",          "type": "json"        }      ]    },    "error": {      "examples": [        {          "title": "Error-Response:",          "content": "HTTP/1.1 422 Not Found  422错误提示,请使用ajax异常扑获取\n {\n     \"message\": \"The given data was invalid.\",\n         \"errors\": {\n              \"type\": [\n                  \"type 不能为空。\"\n              ]\n          }\n       }",          "type": "json"        },        {          "title": "Error-Response:",          "content": "{\n    \"status\":\"400\",\n    \"msg\":\"错误提示\",\n    \"data\":[]\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/AddressController.php",    "groupTitle": "F_Address"  },  {    "type": "POST",    "url": "address/store",    "title": "增加地址",    "sampleRequest": [      {        "url": "https://echoyes.com/api/v1/address/store"      }    ],    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "to_name",            "description": "<p>收件人(必填)</p>"          },          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "mobile",            "description": "<p>收件人手机号(必填)</p>"          },          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "province",            "description": "<p>省id(必填)</p>"          },          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "city",            "description": "<p>市(必填)</p>"          },          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "area",            "description": "<p>区(选填)</p>"          },          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "detail",            "description": "<p>详细地址(选填)</p>"          },          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "postcode",            "description": "<p>邮政编码(选填)</p>"          }        ]      }    },    "header": {      "fields": {        "Header": [          {            "group": "Header",            "type": "String",            "optional": false,            "field": "authorization",            "description": "<p>Authorization value.</p>"          }        ]      }    },    "permission": [      {        "name": "无"      }    ],    "name": "address_store",    "group": "F_Address",    "version": "1.0.0",    "description": "<p>api   增加地址接口</p>",    "success": {      "examples": [        {          "title": "Success-Response:",          "content": "HTTP/1.1 200 OK\n{\n     \"status\":\"200\",\n     \"msg\":\"添加成功\",\n     \"data\":[]\n}",          "type": "json"        }      ]    },    "error": {      "examples": [        {          "title": "Error-Response:",          "content": "HTTP/1.1 422 Not Found  422错误提示,请使用ajax异常扑获取\n {\n     \"message\": \"The given data was invalid.\",\n         \"errors\": {\n              \"type\": [\n                  \"type 不能为空。\"\n              ]\n          }\n       }",          "type": "json"        },        {          "title": "Error-Response:",          "content": "{\n    \"status\":\"400\",\n    \"msg\":\"错误提示\",\n    \"data\":[]\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/AddressController.php",    "groupTitle": "F_Address"  },  {    "type": "POST",    "url": "address/update/:id",    "title": "修改地址",    "sampleRequest": [      {        "url": "https://echoyes.com/api/v1/address/update/:id"      }    ],    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "to_name",            "description": "<p>收件人(必填)</p>"          },          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "mobile",            "description": "<p>收件人手机号(必填)</p>"          },          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "province",            "description": "<p>省id(必填)</p>"          },          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "city",            "description": "<p>市(必填)</p>"          },          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "area",            "description": "<p>区(选填)</p>"          },          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "detail",            "description": "<p>详细地址(选填)</p>"          },          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "postcode",            "description": "<p>邮政编码(选填)</p>"          }        ]      }    },    "header": {      "fields": {        "Header": [          {            "group": "Header",            "type": "String",            "optional": false,            "field": "authorization",            "description": "<p>Authorization value.</p>"          }        ]      }    },    "permission": [      {        "name": "无"      }    ],    "name": "address_update",    "group": "F_Address",    "version": "1.0.0",    "description": "<p>api   修改地址接口</p>",    "success": {      "examples": [        {          "title": "Success-Response:",          "content": "HTTP/1.1 200 OK\n{\n     \"status\":\"200\",\n     \"msg\":\"修改成功\",\n     \"data\":[]\n}",          "type": "json"        }      ]    },    "error": {      "examples": [        {          "title": "Error-Response:",          "content": "HTTP/1.1 422 Not Found  422错误提示,请使用ajax异常扑获取\n {\n     \"message\": \"The given data was invalid.\",\n         \"errors\": {\n              \"type\": [\n                  \"type 不能为空。\"\n              ]\n          }\n       }",          "type": "json"        },        {          "title": "Error-Response:",          "content": "{\n    \"status\":\"400\",\n    \"msg\":\"错误提示\",\n    \"data\":[]\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/AddressController.php",    "groupTitle": "F_Address"  },  {    "type": "POST",    "url": "order",    "title": "订单列表",    "sampleRequest": [      {        "url": "https://echoyes.com/api/v1/order"      }    ],    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "status",            "description": "<p>订单状态(-1取消 0待付款 1待发货 2待收货 3已完成)</p>"          }        ]      }    },    "header": {      "fields": {        "Header": [          {            "group": "Header",            "type": "String",            "optional": false,            "field": "authorization",            "description": "<p>Authorization value.</p>"          }        ]      }    },    "permission": [      {        "name": "无"      }    ],    "name": "order",    "group": "F_Order",    "version": "1.0.0",    "description": "<p>api   订单列表</p>",    "success": {      "examples": [        {          "title": "Success-Response:",          "content": "HTTP/1.1 200 OK\n{\n     \"status\":\"200\",\n     \"msg\":\"获取成功\",\n     \"data\":[]\n}",          "type": "json"        }      ]    },    "error": {      "examples": [        {          "title": "Error-Response:",          "content": "HTTP/1.1 422 Not Found  422错误提示,请使用ajax异常扑获取\n {\n     \"message\": \"The given data was invalid.\",\n         \"errors\": {\n              \"type\": [\n                  \"type 不能为空。\"\n              ]\n          }\n       }",          "type": "json"        },        {          "title": "Error-Response:",          "content": "{\n    \"status\":\"400\",\n    \"msg\":\"错误提示\",\n    \"data\":[]\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/OrderController.php",    "groupTitle": "F_Order"  },  {    "type": "POST",    "url": "order/store/:good_id/:address_id",    "title": "下单",    "sampleRequest": [      {        "url": "https://echoyes.com/api/v1/order/store/:good_id/:address_id"      }    ],    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "Number",            "optional": false,            "field": "quantity",            "description": "<p>购买数量(必填)</p>"          }        ]      }    },    "header": {      "fields": {        "Header": [          {            "group": "Header",            "type": "String",            "optional": false,            "field": "authorization",            "description": "<p>Authorization value.</p>"          }        ]      }    },    "permission": [      {        "name": "无"      }    ],    "name": "order_store",    "group": "F_Order",    "version": "1.0.0",    "description": "<p>api   下单</p>",    "success": {      "examples": [        {          "title": "Success-Response:",          "content": "HTTP/1.1 200 OK\n{\n     \"status\":\"200\",\n     \"msg\":\"下单成功\",\n     \"data\":[]\n}",          "type": "json"        }      ]    },    "error": {      "examples": [        {          "title": "Error-Response:",          "content": "HTTP/1.1 422 Not Found  422错误提示,请使用ajax异常扑获取\n {\n     \"message\": \"The given data was invalid.\",\n         \"errors\": {\n              \"type\": [\n                  \"type 不能为空。\"\n              ]\n          }\n       }",          "type": "json"        },        {          "title": "Error-Response:",          "content": "{\n    \"status\":\"400\",\n    \"msg\":\"错误提示\",\n    \"data\":[]\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/OrderController.php",    "groupTitle": "F_Order"  }] });
