<?php
class WHooked {
	public int $double {
		get {
			return $this->double * 2;
		}
		set(int $value) {
			$this->double = $value;
		}
	}

	public int $one {
		get => 1;
	}
}
