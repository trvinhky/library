<?php 
class DetailLoanModel extends DB {
    protected string $table = 'detailLoan';
    protected array $cols = [
        'loanId', 'bookId', 'loanQuantity'
    ];

    /**
     * lấy số lượng sách đã mượn theo id sách
     *
     * @param string $bookId
     * @return integer
     */
    public function getLoanQuantity(string $bookId) : int {
        $sql = "SELECT d.loanQuantity FROM $this->table d JOIN loans l ON d.loanId = l.loanId WHERE d.bookId = ? AND l.returned = 0";
        $loan = $this->read($sql, [$bookId], 'single');
        if(!empty($loan)) {
            return $loan['loanQuantity'];
        }
        return 0;
    }

    /**
     * lấy chi tiết phiếu mượn theo id phiếu mượn
     *
     * @param string $loanId
     * @param integer $returned
     * @return array
     */
    public function getLoanQuantityByLoanId(string $loanId, int $returned) : array {
        $sql = "SELECT d.*, b.* FROM $this->table d JOIN loans l ON d.loanId = l.loanId JOIN books b ON b.bookId = d.bookId WHERE d.loanId = ? AND l.returned = ?";
        return $this->read($sql, [$loanId, $returned]);
    }

    /**
     * lấy chi tiết phiếu mượn theo id phiếu mượn
     *
     * @param string $loanId
     * @return array
     */
    public function getLoanQuantityByLoan(string $loanId) : array {
        $sql = "SELECT d.*, b.* FROM $this->table d JOIN loans l ON d.loanId = l.loanId JOIN books b ON b.bookId = d.bookId WHERE d.loanId = ?";
        return $this->read($sql, [$loanId]);
    }
}
?>