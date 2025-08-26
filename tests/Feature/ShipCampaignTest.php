<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\ShipCampaignSurvey;

class ShipCampaignTest extends TestCase
{
    use RefreshDatabase;

    public function test_ship_campaign_page_can_be_rendered()
    {
        $response = $this->get('/en/ship-campaign');

        $response->assertStatus(200);
        $response->assertSee('1000 Ships Campaign');
    }

    public function test_ship_campaign_page_can_be_rendered_in_arabic()
    {
        $response = $this->get('/ar/ship-campaign');

        $response->assertStatus(200);
        $response->assertSee('حملة ال1000 سفينة');
    }

    public function test_survey_can_be_submitted()
    {
        $surveyData = [
            'first_name' => 'أحمد',
            'last_name' => 'محمد',
            'whatsapp_number' => '+970599123456',
            'email' => 'ahmed@example.com',
            'age' => 25,
            'question1_answer' => 'القضية الفلسطينية قضية عادلة',
            'question2_answer' => 'يمكن المساهمة من خلال التبرعات',
            'question3_answer' => 'أفضل الطرق هي وسائل الإعلام',
            'question4_answer' => 'تحسين الوضع يتطلب رفع الحصار',
            'question5_answer' => 'فلسطين تحتاج دعمكم',
        ];

        $response = $this->post('/en/ship-campaign', $surveyData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('ship_campaign_surveys', [
            'first_name' => 'أحمد',
            'last_name' => 'محمد',
            'email' => 'ahmed@example.com',
        ]);
    }

    public function test_survey_validation_requires_required_fields()
    {
        $response = $this->post('/en/ship-campaign', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'first_name',
            'last_name',
            'age',
            'question1_answer',
            'question2_answer',
            'question3_answer',
            'question4_answer',
            'question5_answer',
        ]);
    }

    public function test_survey_validation_accepts_optional_fields()
    {
        $surveyData = [
            'first_name' => 'أحمد',
            'last_name' => 'محمد',
            'age' => 25,
            'question1_answer' => 'القضية الفلسطينية قضية عادلة',
            'question2_answer' => 'يمكن المساهمة من خلال التبرعات',
            'question3_answer' => 'أفضل الطرق هي وسائل الإعلام',
            'question4_answer' => 'تحسين الوضع يتطلب رفع الحصار',
            'question5_answer' => 'فلسطين تحتاج دعمكم',
        ];

        $response = $this->post('/en/ship-campaign', $surveyData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    public function test_age_validation_accepts_valid_range()
    {
        $surveyData = [
            'first_name' => 'أحمد',
            'last_name' => 'محمد',
            'age' => 150, // Invalid age
            'question1_answer' => 'القضية الفلسطينية قضية عادلة',
            'question2_answer' => 'يمكن المساهمة من خلال التبرعات',
            'question3_answer' => 'أفضل الطرق هي وسائل الإعلام',
            'question4_answer' => 'تحسين الوضع يتطلب رفع الحصار',
            'question5_answer' => 'فلسطين تحتاج دعمكم',
        ];

        $response = $this->post('/en/ship-campaign', $surveyData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['age']);
    }

    public function test_email_validation_accepts_valid_email()
    {
        $surveyData = [
            'first_name' => 'أحمد',
            'last_name' => 'محمد',
            'age' => 25,
            'email' => 'invalid-email', // Invalid email
            'question1_answer' => 'القضية الفلسطينية قضية عادلة',
            'question2_answer' => 'يمكن المساهمة من خلال التبرعات',
            'question3_answer' => 'أفضل الطرق هي وسائل الإعلام',
            'question4_answer' => 'تحسين الوضع يتطلب رفع الحصار',
            'question5_answer' => 'فلسطين تحتاج دعمكم',
        ];

        $response = $this->post('/en/ship-campaign', $surveyData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_survey_model_has_correct_attributes()
    {
        $survey = ShipCampaignSurvey::create([
            'first_name' => 'أحمد',
            'last_name' => 'محمد',
            'whatsapp_number' => '+970599123456',
            'email' => 'ahmed@example.com',
            'age' => 25,
            'question1_answer' => 'القضية الفلسطينية قضية عادلة',
            'question2_answer' => 'يمكن المساهمة من خلال التبرعات',
            'question3_answer' => 'أفضل الطرق هي وسائل الإعلام',
            'question4_answer' => 'تحسين الوضع يتطلب رفع الحصار',
            'question5_answer' => 'فلسطين تحتاج دعمكم',
        ]);

        $this->assertEquals('أحمد محمد', $survey->full_name);
        $this->assertEquals(25, $survey->age);
        $this->assertEquals('+970599123456', $survey->whatsapp_number);
        $this->assertEquals('ahmed@example.com', $survey->email);
    }
}
