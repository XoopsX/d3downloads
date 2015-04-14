<?php

define( '_MD_D3DOWNLOADS_FILTERS_XPWIKI_TITLE','xpWiki renderer' );

if ( ! function_exists('d3downloads_xpwiki') ) {
	function d3downloads_xpwiki( $text, $html, $smiley, $xcode, $image, $br )
	{
		if ( ! class_exists( 'd3downloadsTextSanitizer' ) ) {
			require_once dirname( dirname( dirname(__FILE__) ) ).'/class/d3downloads.textsanitizer.php' ;
		}
		$myts =& d3downloadsTextSanitizer::sGetInstance() ;
		if ( ! class_exists( 'XpWiki' ) ) {
			@ include_once XOOPS_TRUST_PATH.'/modules/xpwiki/include.php' ;
		}
		if( ! class_exists( 'XpWiki' ) ) die( 'xpWiki is not installed correctly' ) ;

		// Get instance. option is xpWiki module's directory name.
		// �����ϡ�xpWiki�򥤥󥹥ȡ��뤷���ǥ��쥯�ȥ�̾�Ǥ���
		$wiki =& XpWiki::getSingleton( 'xpwiki' );
	
		// xpWiki ��ư�����ꤹ�������ͤ��ѹ��Ǥ��ޤ���
		// $wiki->setIniConst( '[KEY]' , '[VALUE]' ); // $wiki->root->[KEY] = [VALUE];
		// $wiki->setIniRoot( '[KEY]' , '[VALUE]' );  // $wiki->cont->[KEY] = [VALUE];
	
		// ex, ���Ԥ�ͭ���ˤ���
		$wiki->setIniRoot( 'line_break' , 1 );
		// ex. ������󥰥���å���򤹤�
		$wiki->setIniRoot( 'render_use_cache' , 1 );
		// ex. ������󥰥���å����ͭ�����¤Ͽ����˥ڡ��������������ޤ�
		$wiki->setIniRoot( 'render_cache_min' , 0 ); // ����å���ͭ������(ʬ)
		// ex. ������󥯤� target °�� '_blank'
		$wiki->setIniRoot( 'link_target' , '_blank' );
	
		if ($html != 1) {
 			// ��������ϡ�xpWiki��CSS��Ŭ�Ѥ��뤿���DIV���饹̾
			// �̾磻�󥹥ȡ��뤷���ǥ��쥯�ȥ�̾�Ǥ���
			// CSS ��Ŭ�Ѥ��ʤ����϶��� '' ��OK��
			$text = $wiki->transform( $text , 'xpwiki' ) ;
		} else {
			$text = $myts->codePreConv( $text, $xcode ) ;
 			$text = $myts->makeClickable( $text );
			if( $smiley != 0 ) $text = $myts->smiley( $text ) ;
		}
		if( $xcode != 0 ) $text = $myts->xoopsCodeDecode( $text, $image ) ;
		if( $html && $br != 0) $text = $myts->nl2Br( $text ) ;
		if( $html ) $text = $myts->codeConv( $text, $xcode, $image ) ;
		$text = $myts->postCodeDecode( $text , $image ) ;
		return $text;
	}
}

?>