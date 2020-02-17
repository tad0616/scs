<?php
/**
 * Scs module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright  The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package    Scs
 * @since      2.5
 * @author     tad
 * @version    $Id $
 **/

xoops_loadLanguage('modinfo_common', 'tadtools');

define('_MI_SCS_NAME', '國中輔導系統');
define('_MI_SCS_AUTHOR', '國中輔導系統');
define('_MI_SCS_CREDITS', '南科實中');
define('_MI_SCS_DESC', '南科實中開發的國中輔導系統');
define('_MI_SCS_AUTHOR_WEB', 'Tad教材網');
define('_MI_SCS_ADM_PAGE_0', '學籍匯入');
define('_MI_SCS_ADM_PAGE_0_DESC', '學籍匯入');
define('_MI_SCS_ADM_PAGE_1', '導師設定');
define('_MI_SCS_ADM_PAGE_1_DESC', '導師設定');
define('_MI_SCS_ADM_PAGE_2', '權限管理');
define('_MI_SCS_ADM_PAGE_2_DESC', '權限管理');
define('_MI_SCS_PAGE_1', '個別諮商');

define('_MI_SCS_SCHOOL_CODE', '教育部學校代碼');
define('_MI_SCS_SCHOOL_CODE_DESC', '用來篩選學校教職員用，可至 <a href="http://203.68.32.190/code_new.aspx" target="_blank">http://203.68.32.190/code_new.aspx</a> 查詢');

define('_MI_SCS_SCHOOL_NAME', '學校名稱');
define('_MI_SCS_SCHOOL_NAME_DESC', '用於輸出綜合資料紀錄表標題用');

define('_MI_SCS_STU_BLOOD', '血型');
define('_MI_SCS_STU_BLOOD_DESC', '血型選項（請用;隔開，盡量不要有任何空白）');

define('_MI_SCS_STU_RELIGION', '宗教');
define('_MI_SCS_STU_RELIGION_DESC', '宗教選項（請用;隔開，盡量不要有任何空白）');
define('_MI_SCS_STU_RELIGION_DEFAULT', ';無;佛教;道教;回教;基督教;天主教;一貫道;其他');

define('_MI_SCS_STU_BIRTH_PLACE', '出生地');
define('_MI_SCS_STU_BIRTH_PLACE_DESC', '出生地選項（請用;隔開，盡量不要有任何空白）');
define('_MI_SCS_STU_BIRTH_PLACE_DEFAULT', ';基隆市;臺北市;臺北縣;桃園市;桃園縣;新竹市;新竹縣;苗栗縣;臺中市;臺中縣;彰化縣;南投縣;嘉義市;臺南市;臺南縣;高雄市;高雄縣;屏東縣;宜蘭縣;花蓮縣;臺東縣;澎湖縣;金門縣;連江縣;美國;大陸;越南;菲律賓;印尼;泰國;加拿大;日本;香港');

define('_MI_SCS_STU_IDENTITY', '身份註記');
define('_MI_SCS_STU_IDENTITY_DESC', '身份註記選項（請用;隔開，盡量不要有任何空白）');
define('_MI_SCS_STU_IDENTITY_DEFAULT', ';原住民助學金;原住民住宿;學雜費補助;身心障礙學生;身心障礙人士子女;低收入戶學生;身心障礙人士子女-輕;低收入戶;中低收入戶');

define('_MI_SCS_PARENT_JOB', '職業');
define('_MI_SCS_PARENT_JOB_DESC', '職業選項（請用;隔開，盡量不要有任何空白）');
define('_MI_SCS_PARENT_JOB_DEFAULT', '無;公;教;軍;工;商;農;漁;林;牧;退休;家管');

define('_MI_SCS_PARENT_EDU', '教育程度');
define('_MI_SCS_PARENT_EDU_DESC', '教育程度選項（請用;隔開，盡量不要有任何空白）');
define('_MI_SCS_PARENT_EDU_DEFAULT', ';小學;國中;高中職;專科;學士;碩士;博士');

define('_MI_SCS_GUARDIAN_TITLE', '監護人關係');
define('_MI_SCS_GUARDIAN_TITLE_DESC', '監護人關係選項（請用;隔開，盡量不要有任何空白）');
define('_MI_SCS_GUARDIAN_TITLE_DEFAULT', ';母;父;外公;外婆;祖父;祖母;兄;姐;伯父;叔父;姑姑;阿姨;舅舅');

define('_MI_SCS_PARENTAL_RELATIONSHIP', '父母關係');
define('_MI_SCS_PARENTAL_RELATIONSHIP_DESC', '父母關係選項（請用;隔開，盡量不要有任何空白）');
define('_MI_SCS_PARENTAL_RELATIONSHIP_DEFAULT', ';同住;分住;分居;離婚;單親;不詳;失親');

define('_MI_SCS_PARENT_SURVIVE', '父母存歿');
define('_MI_SCS_PARENT_SURVIVE_DESC', '存歿選項');
define('_MI_SCS_PARENT_SURVIVE_DEFAULT', '存;歿;失蹤');

define('_MI_SCS_FAMILY_ATMOSPHERE', '家庭氣氛');
define('_MI_SCS_FAMILY_ATMOSPHERE_DESC', '家庭氣氛選項（請用;隔開，盡量不要有任何空白）');
define('_MI_SCS_FAMILY_ATMOSPHERE_DEFAULT', ';很和諧;和諧;普通;不和諧;很不和諧');

define('_MI_SCS_DISCIPLINE', '管教方式');
define('_MI_SCS_DISCIPLINE_DESC', '管教方式選項（請用;隔開，盡量不要有任何空白）');
define('_MI_SCS_DISCIPLINE_DEFAULT', ';民主;權威;放任');

define('_MI_SCS_ENVIRONMENT', '居住環境');
define('_MI_SCS_ENVIRONMENT_DESC', '居住環境選項（請用;隔開，盡量不要有任何空白）');
define('_MI_SCS_ENVIRONMENT_DEFAULT', ';住宅區;商業區;混合區;軍眷區;農村;漁村;工礦區;山地;違建區;工業區');

define('_MI_SCS_ACCOMMODATION', '本人住宿');
define('_MI_SCS_ACCOMMODATION_DESC', '本人住宿選項（請用;隔開，盡量不要有任何空白）');
define('_MI_SCS_ACCOMMODATION_DEFAULT', ';住家裡;寄居親友;在外租屋;台南學苑;網球隊住宿');

define('_MI_SCS_ECONOMIC', '經濟狀況');
define('_MI_SCS_ECONOMIC_DESC', '經濟狀況選項（請用;隔開，盡量不要有任何空白）');
define('_MI_SCS_ECONOMIC_DEFAULT', ';富裕;小康;普通;清寒;貧困');

define('_MI_SCS_FEEL', '零用錢感受');
define('_MI_SCS_FEEL_DESC', '零用錢感受選項（請用;隔開，盡量不要有任何空白）');
define('_MI_SCS_FEEL_DEFAULT', ';足夠;剛好;不夠');

define('_MI_SCS_FAVORITE_SUBJECT', '學科');
define('_MI_SCS_FAVORITE_SUBJECT_DESC', '學科選項（請用;隔開，盡量不要有任何空白）');
define('_MI_SCS_FAVORITE_SUBJECT_DEFAULT', '國文;英語;數學;社會;歷史;地理;公民;自然;生物;體育;健康教育;音樂;美術;綜合活動;電腦;童軍;家政;輔導');

define('_MI_SCS_EXPERTISE', '特殊專長');
define('_MI_SCS_EXPERTISE_DESC', '特殊專長選項（請用;隔開，盡量不要有任何空白）');
define('_MI_SCS_EXPERTISE_DEFAULT', '球類;游泳;國術;美術;樂器;歌唱;工藝;家事;演說;寫作;舞蹈;戲劇;書法;珠算;外語;中打;會計統計;領導;電腦;英打');

define('_MI_SCS_INTEREST', '休閒興趣');
define('_MI_SCS_INTEREST_DESC', '休閒興趣選項（請用;隔開，盡量不要有任何空白）');
define('_MI_SCS_INTEREST_DEFAULT', '影視;閱讀;登山;露營;旅行;游泳;釣魚;演奏;歌唱;音樂;舞蹈;繪畫;集郵;打球;國術;編織;寵物;栽培;電腦;逛街;下棋');

define('_MI_SCS_CADRE', '班級幹部');
define('_MI_SCS_CADRE_DESC', '班級幹部選項（請用;隔開，盡量不要有任何空白）');
define('_MI_SCS_CADRE_DEFAULT', '無;班長;副班長;風紀股長;衛生股長;學藝股長;輔導股長;事務股長;服務股長;實習股長;資源回收股長;圖書館股長;康樂股長');

define('_MI_SCS_CONSULT_MOTIVATION', '來談動機');
define('_MI_SCS_CONSULT_MOTIVATION_DESC', '來談動機選項（請用;隔開，盡量不要有任何空白）');
define('_MI_SCS_CONSULT_MOTIVATION_DEFAULT', ';主動來談;教師轉介;約談;同學引介;其他;家長轉介');

define('_MI_SCS_CONSULT_KIND', '問題類別');
define('_MI_SCS_CONSULT_KIND_DESC', '問題類別選項（請用;隔開，盡量不要有任何空白）');
define('_MI_SCS_CONSULT_KIND_DEFAULT', ';學習;升學問題;課程選修;人際關係;異性交友;家庭;心理困擾;健康;生活適應;就業;問題行為;其他;轉科選組;精神疾病');

define('_MI_SCS_CONSULT_METHOD', '處理方式');
define('_MI_SCS_CONSULT_METHOD_DESC', '處理方式選項（請用;隔開，盡量不要有任何空白）');
define('_MI_SCS_CONSULT_METHOD_DEFAULT', ';會商處理;轉介輔導;提供諮詢;個案研究;個別諮商;提供認輔;團體輔導;轉介醫療;電話協談;輔導諮商;其他');
