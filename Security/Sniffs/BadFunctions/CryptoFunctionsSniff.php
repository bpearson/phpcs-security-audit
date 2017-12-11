<?php


class Security_Sniffs_BadFunctions_CryptoFunctionsSniff implements \PHP_CodeSniffer\Sniffs\Sniff  {
	/**
	* Returns the token types that this sniff is interested in.
	*
	* @return array(int)
	*/
	public function register() {
		return array(T_STRING);
	}

	/**
	* Processes the tokens that this sniff is interested in.
	*
	* @param \PHP_CodeSniffer\Files\File $phpcsFile The file where the token was found.
	* @param int                  $stackPtr  The position in the stack where
	*                                        the token was found.
	*
	* @return void
	*/
	public function process(\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr) {
		// Run this sniff only in paranoia mode
		if (!$phpcsFile->config->ParanoiaMode) {
			return;
		}
		$utils = Security_Sniffs_UtilsFactory::getInstance();
		$tokens = $phpcsFile->getTokens();
		if (preg_match("/^mcrypt_/", $tokens[$stackPtr]['content']) || in_array($tokens[$stackPtr]['content'], $utils::getCryptoFunctions())) {
			$phpcsFile->addWarning('Crypto function ' . $tokens[$stackPtr]['content'] . ' used.', $stackPtr, 'WarnCryptoFunc');
		}
	}

}

?>
