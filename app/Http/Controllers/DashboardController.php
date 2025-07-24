<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lecturer;
use App\Models\Student;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * Menampilkan ringkasan data untuk dashboard.
     *
     * Method ini akan mengambil jumlah total mahasiswa, dosen, mata kuliah,
     * dan data pendaftaran (enrollment) untuk ditampilkan sebagai statistik
     * utama pada dashboard aplikasi.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        // Mengambil jumlah total dari setiap model
        $totalStudents = Student::count();
        $totalLecturers = Lecturer::count();
        $totalCourses = Course::count();
        $totalEnrollments = Enrollment::count();

        // Menyusun data dalam format array asosiatif
        $summaryData = [
            'total_students'    => $totalStudents,
            'total_lecturers'   => $totalLecturers,
            'total_courses'     => $totalCourses,
            'total_enrollments' => $totalEnrollments,
        ];

        // Mengembalikan data sebagai JSON response
        return response()->json($summaryData, 200);
    }
}
