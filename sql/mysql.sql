CREATE TABLE `tad_honor` (
  `honor_sn` smallint(6) unsigned NOT NULL AUTO_INCREMENT COMMENT '編號',
  `honor_title` varchar(255) NOT NULL DEFAULT '' COMMENT '標題',
  `honor_date` date NOT NULL  COMMENT '發佈日期',
  `honor_unit` varchar(255) NOT NULL DEFAULT '' COMMENT '發布單位',
  `honor_counter` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '點閱次數',
  `honor_content` text NOT NULL COMMENT '詳細內容',
  `honor_url` varchar(255) NOT NULL DEFAULT '' COMMENT '相關連結',
  `honor_uid` mediumint(9) unsigned NOT NULL DEFAULT '0' COMMENT '發布者',
  PRIMARY KEY (`honor_sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `tad_honor_files_center` (
    `files_sn` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '檔案流水號',
    `col_name` varchar(255) NOT NULL default '' COMMENT '欄位名稱',
    `col_sn` smallint(5) unsigned NOT NULL default 0 COMMENT '欄位編號',
    `sort` smallint(5) unsigned NOT NULL default 0 COMMENT '排序',
    `kind` enum('img','file') NOT NULL default 'img' COMMENT '檔案種類',
    `file_name` varchar(255) NOT NULL default '' COMMENT '檔案名稱',
    `file_type` varchar(255) NOT NULL default '' COMMENT '檔案類型',
    `file_size` int(10) unsigned NOT NULL default 0 COMMENT '檔案大小',
    `description` text NOT NULL COMMENT '檔案說明',
    `counter` mediumint(8) unsigned NOT NULL default 0 COMMENT '下載人次',
    `original_filename` varchar(255) NOT NULL default '' COMMENT '檔案名稱',
    `hash_filename` varchar(255) NOT NULL default '' COMMENT '加密檔案名稱',
    `sub_dir` varchar(255) NOT NULL default '' COMMENT '檔案子路徑',
    `upload_date` datetime NOT NULL COMMENT '上傳時間',
    `uid` mediumint(8) unsigned NOT NULL default 0 COMMENT '上傳者',
    `tag` varchar(255) NOT NULL default '' COMMENT '註記',
    PRIMARY KEY (`files_sn`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
