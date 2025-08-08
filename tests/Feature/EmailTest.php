<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Booking;
use App\Models\User;
use App\Mail\BookingNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

class EmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function booking_sends_email_to_support()
    {
        // Fake the mail system to capture emails
        Mail::fake();

        // Create a test user
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com'
        ]);

        // Act as the test user
        $this->actingAs($user);

        // Make a booking request
        $bookingData = [
            'city' => 'Dubai',
            'date' => now()->addDay()->format('Y-m-d'),
            'time' => '10:00',
            'pickup_location' => 'Dubai Mall',
            'pickup_lat' => 25.1972,
            'pickup_lng' => 55.2796,
            'dropoff_location' => 'Burj Khalifa',
            'dropoff_lat' => 25.1963,
            'dropoff_lng' => 55.2741,
        ];

        // Submit the booking
        $response = $this->postJson('/booking', $bookingData);

        // Assert the booking was successful
        $response->assertJson(['success' => true]);

        // Assert that an email was sent to support@tawasullimo.ae
        Mail::assertSent(BookingNotification::class, function ($mail) {
            return $mail->hasTo('support@tawasullimo.ae');
        });

        // Assert only one email was sent
        Mail::assertSent(BookingNotification::class, 1);
    }

    /** @test */
    public function booking_notification_email_has_correct_content()
    {
        // Create a test booking
        $booking = Booking::factory()->create([
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'pickup_location' => 'Dubai Mall',
            'dropoff_location' => 'Burj Khalifa',
            'date' => '2024-01-15',
            'time' => '14:30',
            'city' => 'Dubai'
        ]);

        // Create the mail instance
        $mail = new BookingNotification($booking);

        // Check the envelope
        $envelope = $mail->envelope();
        $this->assertEquals('New Booking Request - Tawasul Limousine', $envelope->subject);
        $this->assertEquals(config('mail.from.address', 'noreply@tawasullimo.ae'), $envelope->from[0]->address);

        // Check the content
        $content = $mail->content();
        $this->assertEquals('emails.booking-notification', $content->view);
    }

    /** @test */
    public function email_configuration_is_correct()
    {
        // Check that the email configuration is set correctly
        $this->assertEquals('smtp.gmail.com', config('mail.mailers.smtp.host'));
        $this->assertEquals(587, config('mail.mailers.smtp.port'));
        $this->assertEquals('tls', config('mail.mailers.smtp.encryption'));
        $this->assertEquals('noreply@tawasullimo.ae', config('mail.from.address'));
        $this->assertEquals('Tawasul Limousine', config('mail.from.name'));
    }

    /** @test */
    public function booking_continues_even_if_email_fails()
    {
        // This test ensures that if email sending fails, the booking still succeeds
        
        // Create a test user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Mock Mail to throw an exception
        Mail::shouldReceive('to')->andThrow(new \Exception('SMTP Error'));

        $bookingData = [
            'city' => 'Dubai',
            'date' => now()->addDay()->format('Y-m-d'),
            'time' => '10:00',
            'pickup_location' => 'Dubai Mall',
            'dropoff_location' => 'Burj Khalifa',
        ];

        // The booking should still succeed even if email fails
        $response = $this->postJson('/booking', $bookingData);
        $response->assertJson(['success' => true]);

        // Verify the booking was created in the database
        $this->assertDatabaseHas('bookings', [
            'city' => 'Dubai',
            'pickup_location' => 'Dubai Mall'
        ]);
    }
}