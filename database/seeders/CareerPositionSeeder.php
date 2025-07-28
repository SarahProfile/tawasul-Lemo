<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CareerPosition;

class CareerPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CareerPosition::create([
            'title' => 'Finance & Accounts Executive',
            'image' => 'assets/finance-executive.jpg',
            'responsibilities' => [
                'Maintain and update financial records accurately in QuickBooks, ensuring all transactions are properly categorized.',
                'Record and track Accounts Payable & Accounts Receivable to maintain a clear financial overview.',
                'Maintain an Accounts Payable report and develop a payment schedule to ensure timely payments.',
                'Conduct bank and account reconciliations, identify discrepancies, and resolve issues.',
                'Track and manage chargebacks and disputes with strong supporting documentation.',
                'Organize, label, and manage financial documents in Dropbox for audits and reviews.'
            ],
            'is_active' => true,
            'order' => 1
        ]);

        CareerPosition::create([
            'title' => 'Copywriter Offline Marketing',
            'image' => 'assets/copywriter.jpg',
            'responsibilities' => [
                'Maintain and update financial records accurately in QuickBooks, ensuring all transactions are properly categorized.',
                'Record and track Accounts Payable & Accounts Receivable to maintain a clear financial overview.',
                'Maintain an Accounts Payable report and develop a payment schedule to ensure timely payments.',
                'Conduct bank and account reconciliations, identify discrepancies, and resolve issues.',
                'Track and manage chargebacks and disputes with strong supporting documentation.',
                'Organize, label, and manage financial documents in Dropbox for audits and reviews.'
            ],
            'is_active' => true,
            'order' => 2
        ]);

        CareerPosition::create([
            'title' => 'Data Analyst Mail Plan',
            'image' => 'assets/data-analyst.jpg',
            'responsibilities' => [
                'Maintain and update financial records accurately in QuickBooks, ensuring all transactions are properly categorized.',
                'Record and track Accounts Payable & Accounts Receivable to maintain a clear financial overview.',
                'Maintain an Accounts Payable report and develop a payment schedule to ensure timely payments.',
                'Conduct bank and account reconciliations, identify discrepancies, and resolve issues.',
                'Track and manage chargebacks and disputes with strong supporting documentation.',
                'Organize, label, and manage financial documents in Dropbox for audits and reviews.'
            ],
            'is_active' => true,
            'order' => 3
        ]);
    }
}
