<?php
class QuickViewFactory {

    public array $factory;

    public function __construct() {

        $this->initialization();
    }

    public function initialization(): void
    {
        $this->factory = [
            'style_1' => new QuickViewStyle1(),
            'style_2' => new QuickViewStyle2(),
            'style_3' => new QuickViewStyle3()
        ];
    }

    public function factory(): array
    {
        return $this->factory;
    }
}