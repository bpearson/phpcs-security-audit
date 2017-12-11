<?php


class Security_Sniffs_BadFunctions_NoEvalsSniff implements \PHP_CodeSniffer\Sniffs\Sniff {

	/**
	* Returns the token types that this sniff is interested in.
	*
	* @return array(int)
	*/
	public function register() {
		return array(T_EVAL);
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
		$tokens = $phpcsFile->getTokens();
		$error = 'Please do not use eval() functions';
		$phpcsFile->addError($error, $stackPtr, 'NoEvals');
	}

}

?>
