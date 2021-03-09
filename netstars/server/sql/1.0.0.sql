CREATE TABLE `netstars`.`log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '记录表主键',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '记录标题',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '记录表内容',
  `img_content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '记录表图片内容',
  `type` tinyint(1) NULL DEFAULT 1 COMMENT '类型 1文字 2图片',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态1正常 0删除',
  `create_time` datetime(1) NULL DEFAULT CURRENT_TIMESTAMP(1) COMMENT '创建时间',
  `update_time` datetime(1) NULL ON UPDATE CURRENT_TIMESTAMP(1) COMMENT '更新时间',
  PRIMARY KEY (`id`)
);