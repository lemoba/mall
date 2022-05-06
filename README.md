## 商城微服务

### 1. 环境搭建

#### 1. 2数据表

* 订单表

```sql
CREATE TABLE `order`
(
    `id`          bigint unsigned     NOT NULL AUTO_INCREMENT,
    `uid`         bigint unsigned     NOT NULL DEFAULT '0' COMMENT '用户ID',
    `pid`         bigint unsigned     NOT NULL DEFAULT '0' COMMENT '产品ID',
    `amount`      int(10) unsigned    NOT NULL DEFAULT '0' COMMENT '订单金额',
    `status`      tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态',
    `create_time` timestamp           NULL     DEFAULT CURRENT_TIMESTAMP,
    `update_time` timestamp           NULL     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_uid` (`uid`),
    KEY `idx_pid` (`pid`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
```

* 支付表

```sql
CREATE TABLE `pay`
(
    `id`          bigint unsigned     NOT NULL AUTO_INCREMENT,
    `uid`         bigint unsigned     NOT NULL DEFAULT '0' COMMENT '用户ID',
    `oid`         bigint unsigned     NOT NULL DEFAULT '0' COMMENT '订单ID',
    `amount`      int(10) unsigned    NOT NULL DEFAULT '0' COMMENT '产品金额',
    `source`      tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '支付方式',
    `status`      tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '支付状态',
    `create_time` timestamp           NULL     DEFAULT CURRENT_TIMESTAMP,
    `update_time` timestamp           NULL     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_uid` (`uid`),
    KEY `idx_oid` (`oid`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
```

* 商品表

```sql
CREATE TABLE `product`
(
    `id`          bigint unsigned     NOT NULL AUTO_INCREMENT,
    `name`        varchar(255)        NOT NULL DEFAULT '' COMMENT '产品名称',
    `desc`        varchar(255)        NOT NULL DEFAULT '' COMMENT '产品描述',
    `stock`       int(10) unsigned    NOT NULL DEFAULT '0' COMMENT '产品库存',
    `amount`      int(10) unsigned    NOT NULL DEFAULT '0' COMMENT '产品金额',
    `status`      tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '产品状态',
    `create_time` timestamp           NULL     DEFAULT CURRENT_TIMESTAMP,
    `update_time` timestamp           NULL     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
```

* 用户表

```sql
CREATE TABLE `user`
(
    `id`          bigint unsigned     NOT NULL AUTO_INCREMENT,
    `name`        varchar(255)        NOT NULL DEFAULT '' COMMENT '用户姓名',
    `gender`      tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '用户性别',
    `mobile`      varchar(255)        NOT NULL DEFAULT '' COMMENT '用户电话',
    `password`    varchar(255)        NOT NULL DEFAULT '' COMMENT '用户密码',
    `create_time` timestamp           NULL     DEFAULT CURRENT_TIMESTAMP,
    `update_time` timestamp           NULL     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `idx_mobile_unique` (`mobile`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
```