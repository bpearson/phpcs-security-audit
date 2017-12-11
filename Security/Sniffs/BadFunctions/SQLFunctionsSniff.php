<?php


class Security_Sniffs_BadFunctions_SQLFunctionsSniff implements \PHP_CodeSniffer\Sniffs\Sniff {

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
		$utils = Security_Sniffs_UtilsFactory::getInstance();
		$tokens = $phpcsFile->getTokens();

		// http://www.php.net/manual/en/book.mysql.php
		if ($tokens[$stackPtr]['content'] == 'mysql_query') {
            $opener = $phpcsFile->findNext(T_OPEN_PARENTHESIS, $stackPtr, null, false, null, true);
			$closer = $tokens[$opener]['parenthesis_closer'];
            $s = $stackPtr + 1;
			$s = $phpcsFile->findNext(array_merge(\PHP_CodeSniffer\Util\Tokens::$emptyTokens, \PHP_CodeSniffer\Util\Tokens::$bracketTokens, Security_Sniffs_Utils::$staticTokens, array(T_STRING_CONCAT)), $s, $closer, true);
             if ($s) {
				$msg = 'SQL function ' . $tokens[$stackPtr]['content'] . '() detected with dynamic parameter ';
				if ($utils::is_token_user_input($tokens[$s])) {
					$phpcsFile->addError($msg . ' directly from user input', $stackPtr, 'ErrFilesystem');
				} else {
					$phpcsFile->addWarning($msg, $stackPtr, 'WarnFilesystem');
				}
			}
		}

	}

}


?>
