<?php

namespace Classroom\StudentManagement\Presentation\Web\Controller\Student;

use Classroom\SharedContext\Presentation\Web\Controller\AbstractController;
use Classroom\StudentManagement\Application\UseCase\Command\AddStudent;
use Classroom\StudentManagement\Presentation\Web\Form\StudentType;
use Classroom\StudentManagement\Presentation\WriteModel\StudentModel;
use DomainException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/student/new', name: 'app_student_new', methods: ['GET', 'POST'])]
final class AddStudentController extends AbstractController
{
    public function __invoke(Request $request): Response
    {
        $model = new StudentModel();
        $form = $this->createForm(StudentType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->handleCommand(new AddStudent(
                    $model->email,
                    $model->username,
                    $model->address,
                    $model->birthdate
                ));
            } catch (DomainException $e) {
                $this->addFlash('error', $e->getMessage());
                return $this->redirectToRoute('app_student_new', [], Response::HTTP_SEE_OTHER);
            }
            return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student/new.html.twig', [
            'student' => $model,
            'form' => $form,
        ]);
    }
}
