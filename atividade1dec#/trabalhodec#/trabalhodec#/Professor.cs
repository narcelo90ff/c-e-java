
public class Professor
    {
        public int Id { get; set; }
        public string Nome { get; set; }
        public List<CursoN> Cursos { get; set; } = new List<CursoN>();
    }

    public class CursoN
    {
        public int Id { get; set; }
        public string Nome { get; set; }
        public int ProfessorId { get; set; }
        public Professor Professor { get; set; }
    }

    // --- ATIVIDADE 6: PEDIDO E ITENS (1:N) ---
    public class Pedido
    {
        public int Id { get; set; }
        public DateTime Data { get; set; }
        public List<ItemPedido> Itens { get; set; } = new List<ItemPedido>();

        // Desafio: Calcular total de itens
        public int CalcularTotalItens() => Itens.Sum(i => i.Quantidade);
    }
